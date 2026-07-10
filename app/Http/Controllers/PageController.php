<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Models\User;

class PageController extends Controller
{
   

    public function profilEdit()
    {
        return Inertia::render('EditUser');
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {

        $valData =$request->validated();
        $user =Auth::user();
        if($request->filled('newPassword'))
            {
                $valData['password']=Hash::make($valData['newPassword']);
            }

        if($request->hasFile('image'))
            {
                if($user->image && file_exists(public_path('profile/'.$user->image)))
                    {
                        unlink(public_path('profile/' . $user->image));
                
                    }
                $imageExt =$request->file('image')->getClientOriginalExtension();
                $imageName = $user->name . '_' . time() . '.' . $imageExt;
                $request->file('image')->move(public_path('profile'),$imageName);
                $valData['image']=$imageName;
            }else{
                unset($valData['image']);
            }
        $user->update($valData);
        return redirect()->back()->with('success','Success Updating');
    }
}
