<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class PhotoController extends Controller
{
    //
    public function index()
    {
        // $defaultAuth = Firebase::auth();

        return view("userupload");
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'picture' => 'required|mimes:png,jpg,jpeg'
        ]);

        if ($request->hasFile('picture')) {

            $file = $validated['picture'];

            // Create a reference to the default Firebase Storage bucket
            $defaultBucket = app('firebase.storage')->getBucket();

            // Specify the folder (object path) where we want to store the file
            $folder = 'chatify/';

            // Generate a unique filename
            $filename = uniqid() . '_' . $file->getClientOriginalName();

            // Full path in Firebase Storage including the folder
            $fullPath = $folder . $filename;

            // Get the contents of the file
            $fileContents = file_get_contents($file->getRealPath());

            // Upload the file to Firebase Storage
            $defaultBucket->upload($fileContents, [
                'name' => $fullPath,
            ]);

            return redirect()->back()->with('success', 'Image uploaded successfully.');
        }
        return redirect()->back()->with('error', 'Something went wrong while uploading to the Cloud Storage.');
    }
}
