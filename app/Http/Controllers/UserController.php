<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function editusers($id){
        $user = User::findOrFail($id);
        return view('theme.editusers',compact('user'));
    }
    public function profile(Request $request,$id){

        $request->validate([

            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048000',

        ]);

        // Save the profile image

        $fileUploader = new FileUploader();

        $profileImageName = $fileUploader->upload($request->file('cover_image'), 'uploads/profiles_p');



        DB::table('users')->where('id', $id)->update([
                'cover_image' =>$profileImageName ,


            ]);

        return back();

    }
    public function deleteusers($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back();
    }
    public function updateusers(Request $request,$id){

        $user = User::findOrFail($id);
       $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'status' => 'required',

        ]);


        $user->update($data);
        return redirect()->back()->with('status', 'User updated successfully');
    }
}