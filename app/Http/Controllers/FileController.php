<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getSecureFile($filename) {
        try {
            return response()->download(storage_path('/app/public/uploads/images/avatar/'.$filename), null, [], null);

        } catch(\Exception $e) {
            return 'File Not Found';
        }
    }

    public function getPublicFile($filename) {
        try {
            return response()->download(public_path('/uploads/logo/'.$filename), null, [], null);
        } catch(\Exception $e) {
            return 'File Not Found';
        }
    }

}
