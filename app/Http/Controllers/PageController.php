<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Models\User;
use App\Services\GoogleDriveService;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class PageController extends Controller
{
    public function profilEdit()
    {
        return Inertia::render('EditUser');
    }

    public function profileUpdate(ProfileUpdateRequest $request,GoogleDriveService $driveService)
    {

        $valData = $request->validated();
        $user = Auth::user();
        if ($request->filled('newPassword')) {
            $valData['password'] = Hash::make($valData['newPassword']);
        }

        if ($request->hasFile('image')) {
            if($user->image)
                {
                    $driveService->deleteFile($user->image);
                }
            $fileId =$driveService->upload($valData['image'],env('GOOGLE_DRIVE_PROFILE_FOLDER_ID'));
            $valData ['image']=$fileId;
        } else {
            unset($valData['image']);
        }
        $user->update($valData);
        return redirect()->back()->with('success', 'Success Updating');
    }
}
