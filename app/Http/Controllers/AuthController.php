<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function loginUser(Request $request)
    {
        $valiData =$request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        if(Auth::attempt($valiData))
            {
                return redirect()->route('home')->with('success','Welcome ' . Auth::user()->name);
            }
        return redirect()->back()->with('error','The provided credentials do not match our records.');
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function registerUser(Request $request)
    {
        
    $valiData = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required|min:6',
            'image'=>'nullable|image|mimes:png,jpg,jpeg',
        ]);

        
        if($request->hasFile('image'))
            {
                $originalName =$request->file('image')->getClientOriginalName();
                $imageExt =$request->file('image')->getClientOriginalExtension();
                $imageName = $originalName . '_' . time() . '.' . $imageExt;
                $request->file('image')->move(public_path('profile'),$imageName);
                $valiData['image']=$imageName;
            }else{
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
