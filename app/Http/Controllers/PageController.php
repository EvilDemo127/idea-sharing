<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Models\User;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class PageController extends Controller
{
   private function getGoogleDriveService()
    {
        $client = new \Google\Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
        return new Drive($client);
    }



    public function profilEdit()
    {
        return Inertia::render('EditUser');
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {

        $valData = $request->validated();
        $user = Auth::user();
        if ($request->filled('newPassword')) {
            $valData['password'] = Hash::make($valData['newPassword']);
        }

        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path('profile/' . $user->image))) {
                try {
                    $service = $this->getGoogleDriveService();

                    $service->files->delete($user->image);
                } catch (\Google\Service\Exception $e) {

                    Log::error('Google Drive file delete failed: ' . $e->getMessage());
                }
            }
            $service = $this->getGoogleDriveService();

            $fileMetadata = new DriveFile([
                'name' => time() . '_' . $request->file('image')->getClientOriginalName(),
                'parents' => [env('GOOGLE_DRIVE_GALLERY_FOLDER_ID')]
            ]);

            $content = file_get_contents($request->file('image')->getRealPath());

            $file = $service->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => $request->file('image')->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id'
            ]);

            $permission = new \Google\Service\Drive\Permission([
                'type' => 'anyone',
                'role' => 'reader'
            ]);

            $service->permissions->create($file->id, $permission);
            $valData['image'] = $file->id.'/'.$fileMetadata->name;
        } else {
            unset($valData['image']);
        }
        $user->update($valData);
        return redirect()->back()->with('success', 'Success Updating');
    }
}
