<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Image;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Facades\Auth;
use Kreait\Laravel\Firebase\Facades\Firebase;

class PhotoController extends Controller
{
    //
    public function index()
    {
        // $defaultAuth = Firebase::auth();
        $userId = Auth::id();
        $images = Image::where('user_id', $userId)->get();

        return view("userview")->with('images', $images);
    }

    public function create()
    {
        return view('userupload');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'picture' => 'required|mimes:png,jpg,jpeg'
        ]);

        try {

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

            $userId = Auth::id();
            $img = Image::create([
                'user_id' => $userId,
                'image_path' => $fullPath,
            ]);

            return redirect()->back()->with('success', 'Image has been uploaded successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Upload Failure!');
        }
    }
}
