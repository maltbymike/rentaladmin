<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Upload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Request\UploadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UploadRequest $request)
    {
        // TODO - Add authorization

        $file = $request->file('file');
        $name = $file->hashName();

        $storedFile = $file->store('moneris');

        $data = Upload::firstOrCreate([
            'file_hash' => hash_file(
                config('app.uploads.hash'),
                storage_path(path: "app/moneris/{$name}"),
            ),
        ],
        [
            'name' => "{$name}",
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path' => "moneris/{$name}",
            'disk' => config('app.uploads.disk'),
            'collection' => $request->get('collection'),
            'size' => $file->getSize(),
        ]);

        if ($data->wasRecentlyCreated) {
            $request->session()->flash('success', 'File uploaded');   
        }
        else
        {
            $request->session()->flash('warning', 'Duplicate file: This file has already been uploaded');

            $delete = Storage::disk(config('app.uploads.disk'))->delete($storedFile);
        }

        return redirect()->back();

    }

}
