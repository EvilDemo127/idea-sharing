<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    private function getGoogleDriveService()
    {
        $client = new \Google\Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
        return new Drive($client);
    }

    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function loginUser(Request $request)
    {
        $valiData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($valiData)) {
            return redirect()->route('home')->with('success', 'Welcome ' . Auth::user()->name);
        }
        return redirect()->back()->with('error', 'The provided credentials do not match our records.');
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function registerUser(Request $request)
    {

        $valiData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => [
                'required',
                Password::min(6)
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);


        if ($request->hasFile('image')) {
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
            $valiData['image'] = $file->id;
        } else {
            unset($valiData['image']);
        }
        User::create($valiData);
        return redirect()->route('home')->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
