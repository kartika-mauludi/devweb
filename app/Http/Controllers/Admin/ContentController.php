<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contents;
use App\Models\Feature;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    private $title = 'Master Kelola Content';
    public function index()
    {
        $title = $this->title;
        $data['features'] = Feature::get();
        $data['content'] = Contents::all();
        return view('admin.content.index', compact('title', 'data'));
    }

    public function featureStore(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'icon' => 'nullable|string|max:255',
                'description' => 'nullable|string'
            ]);

            Feature::create($request->all());

            $message = $this::$message['createsuccess'];
        } catch (\Exception $e) {
            report($e);
            $message = $this::$message['error'];
        }

        return redirect()->route('content.index')->with('message', $message);
    }

    public function featureUpdate(Request $request)
    {

        // dd($request->all());
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'icon' => 'nullable|string|max:255',
                'description' => 'nullable|string'
            ]);

            $feature = Feature::findOrFail($request->id);
            $feature->update($request->all());

            $message = $this::$message['updatesuccess'];
        } catch (\Exception $e) {
            report($e);
            $message = $this::$message['error'];
        }

        return redirect()->route('content.index')->with('message', $message);
    }

    public function featureDel($id)
    {
        // dd($id);
        try {
            $feature = Feature::findOrFail($id);
            $feature->delete();

            $message = $this::$message['deletesuccess'];
        } catch (\Exception $e) {
            report($e);
            $message = $this::$message['error'];
        }

        return redirect()->route('content.index')->with('message', $message);
    }

    public function packageStore(Request $request)
    {
        // dd($request->all());


        try {
            $validatedData = $request->validate([
                'card_number' => 'nullable|in:1,2,3',
                'title'       => 'nullable|string',
                'price'       => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'feature'     => 'nullable|string',
                'status'      => 'required|in:active,inactive',
            ], [
                // Custom pesan error (opsional)
                'in'      => 'Pilihan untuk :attribute tidak valid.',
                'numeric' => 'Harga harus berupa angka.',
                'min'     => 'Harga tidak boleh minus.',
            ]);

            Contents::create($validatedData);

            $message = $this::$message['createsuccess'];
        } catch (\Exception $e) {
            report($e);
            $message = $this::$message['error'];
        }

        return redirect()->route('content.index')->with('message', $message);
    }

    public function packageUpdate(Request $request)
    {
        // dd($request->all());
        try {
            $validatedData = $request->validate([
                'id'          => 'required|exists:contents,id',
                'card_number' => 'nullable|in:1,2,3',
                'title'       => 'nullable|string',
                'price'       => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'feature'     => 'nullable|string',
                'status'      => 'required|in:active,inactive',
            ], [
                // Custom pesan error (opsional)
                'in'      => 'Pilihan untuk :attribute tidak valid.',
                'numeric' => 'Harga harus berupa angka.',
                'min'     => 'Harga tidak boleh minus.',
            ]);

            $content = Contents::findOrFail($validatedData['id']);
            $content->update($validatedData);

            $message = $this::$message['updatesuccess'];
        } catch (\Exception $e) {
            report($e);
            $message = $this::$message['error'];
        }
        return redirect()->route('content.index')->with('message', $message);
    }

    public function packageDelete($id)
    {
        // dd($id);
        try {
            $content = Contents::findOrFail($id);
            $content->delete();

            $message = $this::$message['deletesuccess'];
        } catch (\Exception $e) {
            report($e);
            $message = $this::$message['error'];
        }

        return redirect()->route('content.index')->with('message', $message);
    }
}
