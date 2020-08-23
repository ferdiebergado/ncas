<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validated = $this->validate(
            $request,
            [
                'file' => 'required|string|max:50'
            ]
        );

        $file = $validated['file'];

        if (Storage::exists($file)) {
            return Storage::download($file);
        }
    }
}
