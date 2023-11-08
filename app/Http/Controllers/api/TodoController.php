<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function importTxt(Request $request)
    {
        $uploadedFile = $request->file('txt_file');

        $contents = Storage::get($uploadedFile->path());

        $lines = explode("\n", $contents);

        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                DB::table('members')->insert([
                    'name' => $line,
                ]);
            }
        }

        return response()->json(['message' => 'TXT file imported successfully']);
    }

    public function dashboard()
    {
        $data_domain = DB::table('members')->get();

        return view('index', [
            'data_domain' => $data_domain,
        ]);
    }
}

