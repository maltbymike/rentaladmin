<?php

namespace App\Http\Livewire\Tools;

use App\Models\Upload;

use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadFile extends Component
{
    use WithFileUploads;

    public $file;
    public $isDisabled = true;

    public function deleteFile(Upload $upload)
    {
        // Remove the file from storage
        $delete = Storage::disk(config('app.uploads.disk'))->delete($upload->path);

        // Delete the record from the database
        $upload->delete();

        // Flash sesion message
        session()->flash('success', 'File removed from storage');
    }

    protected function save(string $path = '', string $collection = '')
    {

        if ($path !== '') {
            
            if ($checkTrailingSlash = substr($path, -1) !== '/') {

                $pathWithTrailingSlash = $path . '/';

            } else {

                $pathWithTrailingSlash = $path;

                $path = substr($path, 0, -1);

            }
        
        }

        $file = $this->file;

        $name = $file->hashName();

        $storedFile = $file->store($path);

        $data = Upload::firstOrCreate([
            'file_hash' => hash_file(
                config('app.uploads.hash'),
                storage_path(path: "app/{$pathWithTrailingSlash}{$name}"),
            ),
        ],
        [
            'name' => "{$name}",
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path' => "{$pathWithTrailingSlash}{$name}",
            'disk' => config('app.uploads.disk'),
            'collection' => $collection,
            'size' => $file->getSize(),
        ]);

        if ($data->wasRecentlyCreated) {
            session()->flash('success', 'File uploaded');   
        }
        else
        {
            session()->flash('warning', 'Duplicate file: This file has already been uploaded');

            $delete = Storage::disk(config('app.uploads.disk'))->delete($storedFile);
        }

    }

    public function updatedFile()
    {

        $this->isDisabled = true;
        
        $this->validateOnly('file');

        $this->isDisabled = false;

    }

}
