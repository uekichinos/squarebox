<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Http\Request;
use App\Models\PasswordHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdatePictureProfileRequest;
use App\Http\Requests\UpdateProfileProfileRequest;
use App\Http\Requests\UpdatePasswordProfileRequest;

class ProfileController extends Controller
{

    /**
     * Form edit profile
     */
    public function EditProfile() 
    {
        $user = User::find(Auth::user()->id);
        return view('profile.profile', ['user' => $user]);
    }

    /**
     * Update profile
     */
    public function UpdateProfile(UpdateProfileProfileRequest $request)
    {
        $request = $request->validated();
        
        $id = Auth::user()->id;

		$user = User::find($id);
		$user->name = $request['name'];
		$user->email = $request['email'];
		$user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Form update password
     */
    public function EditPassword() 
    {
        $user = User::find(Auth::user()->id);
        return view('profile.password', ['user' => $user]);
    }

    /**
     * Update profile password.
     */
    public function UpdatePassword(UpdatePasswordProfileRequest $request)
    {
        $request = $request->validated();
        
        $id = Auth::user()->id;

		$user = User::find(Auth::user()->id);
		$user->password = Hash::make($request['password']);
        $user->password_updated_at = date("Y-m-d H:i:s");
		$user->save();

        PasswordHistory::capturePassword($request['password']);

        return redirect()->route('passwd.edit')->with('success', 'Password updated successfully!');
    }

    /**
     * Form image upload
     */
    public function EditPicture() 
    {
        $user = User::find(Auth::user()->id);
        return view('profile.picture', ['user' => $user]);
    }

    /**
     * Update image profile.
     */
    public function UpdatePicture(UpdatePictureProfileRequest $request)
    {
        $request = $request->validated();
        
		$user = User::find(Auth::user()->id);

        if($user->picture != 'default.png') {
            unlink(storage_path().('/app/public/img/avatars/'.$user->picture));
        }

        // $picture = $request->file('picture');
        $picture = $request['picture'];
        $filename = Crypt::encryptString(time()).'.' . $picture->getClientOriginalExtension();
        Image::make($picture)->resize(300, 300)->save(storage_path().('/app/public/img/avatars/'.$filename));

		$user->picture = $filename;
		$user->save();

        return redirect()->route('picture.edit')->with('success', 'Picture updated successfully!');
    }
}
