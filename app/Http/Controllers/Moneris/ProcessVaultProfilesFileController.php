<?php

namespace App\Http\Controllers\Moneris;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moneris\ProcessVaultProfilesFileRequest;

use App\Jobs\Moneris\ProcessVaultProfilesCsvChunkJob;

use App\Models\Upload;
use App\Models\Moneris\MonerisToken;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessVaultProfilesFileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Moneris\ProcessVaultProfilesFileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProcessVaultProfilesFileRequest $request)
    {
        // TODO - Add Authorization

        $fileInfo = Upload::firstWhere('file_hash', $request->file);

        $file = Storage::disk(config('app.uploads.disk'))->get($fileInfo->path);

        $data = preg_split("/((\r?\n)|(\r\n?))/", $file);

        foreach(array_chunk($data, 100) as $key => $chunk) {

            $content = implode("\n", $chunk);

            $fileName = "moneris/chunk/chunk-{$key}.csv";

            Storage::disk(config('app.uploads.disk'))->put($fileName, $content);

            ProcessVaultProfilesCsvChunkJob::dispatch($fileName);

        }        
        
        $request->session()->flash('success', 'The file has been queue for processing'); 

        return redirect()->back();

    }

}
