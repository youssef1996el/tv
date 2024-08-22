<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\File as FileModel;
use DB;
class FileController extends Controller
{
    public function store(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480', // Adjust as necessary
        ]);

        // Check if the directory exists, if not create it
        $destinationPath = public_path('/files');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Store the file
        $file = $request->file('file');
        $filePath = $file->store('files', 'public');

        // Save the file path to the database
        $fileModel = new FileModel();
        $fileModel->path = $filePath;
        $fileModel->save();

        return back()->with('success', 'File uploaded successfully');
    }

    public function getFile(Request $request)
    {
        $File = DB::select('select  path from files limit 1');

        return response()->json([
            'status'  => 200,
            'path'    => $File[0]->path,
        ]);
    }
}
