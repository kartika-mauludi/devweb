<?php

namespace App\Http\Controllers;

use App\Models\ConfigAccount;
use App\Models\University;
use App\Models\UniversityAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Fernet\Fernet;
use Illuminate\Support\Facades\DB;
use PSpell\Config;

class EncryptController extends Controller
{
    private $title = 'Config Agent';
    public function index()
    {
        $title = $this->title;
        $dataConfig = ConfigAccount::all();
        return view('admin.encrypt.index', compact('title', 'dataConfig'));
    }

    public function addAsuConfig(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $sumAsu = ConfigAccount::where('name_university', 'Arizona State University')->count();
            $name_config = "asu_" . ($sumAsu + 1);

            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);

            if (ConfigAccount::where('username', $request->username)
                ->where('name_university', 'Arizona State University')
                ->exists()
            ) {
                return [
                    'statusCode' => 302,
                ];
            }

            ConfigAccount::create([
                'name_university' => $request->name,
                'name_config' => $name_config,
                'username' => $request->username,
                'password' => $request->password,
                'address' => $request->address,
            ]);

            $asu = University::where('name', 'Arizona State University')->firstOrFail();

            if (UniversityAccount::where('username', $request->username)
                ->where('university_id', $asu->id)
                ->exists()
            ) {
                return [
                    'statusCode' => 302,
                ];
            }

            UniversityAccount::create([
                'university_id' => $asu->id,
                'username' => $request->username,
                'password' => $request->password
            ]);

            return [
                'statusCode' => 200,
            ];
        });

        if ($result['statusCode'] == 302) {
            return redirect()->back()->with('message', '❌ Akun sudah ada di database');
        } else if ($result['statusCode'] == 200) {
            return redirect()->back()->with('message', '✅ Data berhasil disimpan');
        }
    }

    public function addUnairConfig(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $sumUnair = ConfigAccount::where('name_university', 'Universitas Airlangga')->count();
            $name_config = "unair_" . ($sumUnair + 1) . ".ovpn";

            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
                'address' => 'required',
            ]);

            if (ConfigAccount::where('username', $request->username)
                ->where('name_university', 'Universitas Airlangga')
                ->exists()
            ) {
                return [
                    'statusCode' => 302,
                ];
            }

            ConfigAccount::create([
                'name_university' => $request->name,
                'name_config' => $name_config,
                'username' => $request->username,
                'password' => $request->password,
                'address' => $request->address,
            ]);

            if ($request->file('config')) {
                $request->file('config')->storeAs('config', $name_config, 'public');
            }

            $unair = University::where('name', 'Universitas Airlangga')->firstOrFail();

            if (UniversityAccount::where('username', $request->username)
                ->where('university_id', $unair->id)
                ->exists()
            ) {
                return [
                    'statusCode' => 302,
                ];
            }

            UniversityAccount::create([
                'university_id' => $unair->id,
                'username' => $request->username,
                'password' => $request->password
            ]);

            return [
                'statusCode' => 200,
            ];
        });

        if ($result['statusCode'] == 302) {
            return redirect()->back()->with('message', '❌ Akun sudah ada di database');
        } else if ($result['statusCode'] == 200) {
            return redirect()->back()->with('message', '✅ Data berhasil disimpan');
        }
    }

    public function destroyConfig($id)
    {

        $config = ConfigAccount::findOrFail($id);
        // dd($config);
        if ($config->name_university == "Arizona State University") {
            $result = DB::transaction(function () use ($config) {
                $asu = University::where('name', 'Arizona State University')->firstOrFail();
                $universityAccount = UniversityAccount::where('username', $config->username)
                    ->where('university_id', $asu->id)
                    ->first();

                if ($universityAccount) {
                    $universityAccount->delete();
                }

                $config->delete();

                return [
                    'status' => 'success'
                ];
            });

            if ($result['status'] == 'success') {
                return redirect()->back()->with('message', '✅ Data berhasil dihapus');
            } else {
                return redirect()->back()->with('message', '❌ Gagal menghapus data');
            }
        } elseif ($config->name_university == "Universitas Airlangga") {
            $result = DB::transaction(function () use ($config) {
                $unair = University::where('name', 'Universitas Airlangga')->firstOrFail();
                $universityAccount = UniversityAccount::where('username', $config->username)
                    ->where('university_id', $unair->id)
                    ->first();

                if ($universityAccount) {
                    $universityAccount->delete();
                }

                if ($config->address != null && $config->address != "") {
                    if (Storage::disk('public')->exists('config/' . $config->name_config)) {
                        Storage::disk('public')->delete('config/' . $config->name_config);
                    }

                    $config->delete();
                }

                return [
                    'status' => 'success',
                ];
            });

            if ($result['status'] == 'success') {
                return redirect()->back()->with('message', '✅ Data berhasil dihapus');
            } else {
                return redirect()->back()->with('message', '❌ Gagal menghapus data');
            }
        }
    }

    public function generate()
    {
        $key = $this->generateFernetKey();

        Storage::disk('public')->put('config/config.key', $key);

        $rows = ConfigAccount::all();

        $mapping = [
            'Arizona State University' => 'ASU',
            'Universitas Airlangga'    => 'UNAIR',
        ];

        $config = [];
        $counter = [];

        foreach ($rows as $row) {
            $prefix = $mapping[$row->name_university] ?? strtoupper(substr($row->name_university, 0, 3));

            if (!isset($counter[$prefix])) {
                $counter[$prefix] = 1;
            } else {
                $counter[$prefix]++;
            }

            $index = $counter[$prefix];

            $config["{$prefix}{$index}.CONFIG"]   = $row->name_config;
            $config["{$prefix}{$index}.USERNAME"] = $row->username;
            $config["{$prefix}{$index}.PASSWORD"] = $row->password;
            $config["{$prefix}{$index}.ADDRESS"]  = $row->address;
        };

        $json = json_encode($config, JSON_UNESCAPED_UNICODE);

        $fernet = new Fernet($key);
        $encrypted = $fernet->encode($json);

        Storage::disk('public')->put('config/config.enc', $encrypted);

        return back()->with('message', '✅ File config.key dan config.enc berhasil dibuat di storage/app');
    }

    private function generateFernetKey(): string
    {
        $raw = random_bytes(32);
        $b64 = rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');
        return $b64 . '=';
    }
}
