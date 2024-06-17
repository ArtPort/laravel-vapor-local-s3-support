<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class Storage
{
    /**
     * Register the local development storage routes.
     *
     */
    public static function localRoutes() : void
    {
        /**
         * Create a new signed storage url.
         *
         */
        Route::name('signed.storage.url')->post('/vapor/signed-storage-url', function() {
            return response()->json([
                'uuid'    => $id      = str()->uuid(),
                'headers' => $headers = compact('id'),
                'url'     => url()->temporarySignedRoute('signed.storage.upload', 5000, $headers),
            ]);
        });

        /**
         * Move a signed file to a temporary location.
         *
         */
        Route::middleware('signed')->name('signed.storage.upload')->put('/vapor/signed-storage-upload/{id}', function() {
            Storage::put('tmp/' . request()->header('id'), request()->getContent());

            return response()->json('The file was uploaded');
        });
    }
}
