<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use View;

class UserController extends Controller
{
    public function user()
    {
        $roles = Role::get(['id', 'name']);
        $users = User::latest()->paginate(25);

        return view('user', compact('roles', 'users'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'phone' => 'required|unique:users|regex:/^(\\+91[\\-\\s]?)?[0]?(91)?[789]\\d{9}$/',
            'description' => 'required',
            'role_id' => 'required',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        $formData = $request->all();
        $validator = Validator::make($formData, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        $imageName = time().'.'.$request->profile_image->extension();
        $request->profile_image->storeAs('public/profile_image', $imageName);
        $formData['profile_image'] = $imageName;
        $user = User::create($formData);
        if ($user) {
            $users = User::latest()->paginate(25)->setPath(route('user'));
            $dataHtml = (string) View::make('userdata', compact('users'));

            return response()->json(['status' => true, 'message' => 'User created successfully.', 'dataHtml' => $dataHtml]);
        }

    }
}
