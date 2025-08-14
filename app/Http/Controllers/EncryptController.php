<?php

namespace App\Http\Controllers;

use App\Models\ConfigAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Fernet\Fernet;
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
        $request->validate([
            'name' => 'required',
            'name_config' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        ConfigAccount::create([
            'name_university' => $request->name,
            'name_config' => $request->name_config,
            'username' => $request->username,
            'password' => $request->password,
        ]);
        return back()->with('success', '✅ Data berhasil disimpan');
    }

    public function addUnairConfig(Request $request)
    {

        // dd($request->all());

        $sumUnair = ConfigAccount::where('name_university', 'Universitas Airlangga')->count();
        // dd($sumUnair);
        $name_config = "unair_" . ($sumUnair + 1) . ".ovpn";

        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'address' => 'required',
        ]);
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

        return back()->with('success', '✅ Data berhasil disimpan');
    }

    public function destroyConfig($id)
    {

        $config = ConfigAccount::findOrFail($id);
        // dd($config->address);

        if ($config->address != null && $config->address != "") {
            if (Storage::disk('public')->exists('config/' . $config->name_config)) {
                Storage::disk('public')->delete('config/' . $config->name_config);
            }
        }

        $config->delete();

        return back()->with('success', '✅ Data berhasil dihapus');
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

        return back()->with('success', '✅ File config.key dan config.enc berhasil dibuat di storage/app');
    }

    private function generateFernetKey(): string
    {
        $raw = random_bytes(32);
        $b64 = rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');
        return $b64 . '=';
    }
}
