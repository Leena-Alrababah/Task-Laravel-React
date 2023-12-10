<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function getAllUsers(){
        $getAllUsers = User::all();
        return response()->json($getAllUsers);
    }


    public function getUser($id)
    {
        $getUser = User::find($id);
        return response()->json($getUser);
    }


    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User([
            'name' => $request->input('name'),
            'image' => $request->input('image'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->save();

        return response()->json(['message' => 'User Added successfully'], 201);
    }


   
    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'string',
                'image' => 'image|mimes:jpeg,png,gif',
                'email' => 'email|unique:users',
                'password' => 'min:8',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // User::where('id', $id)->update([
        //     'name' => $request->name,
        //     'image' => $request->image,
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update fields conditionally
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json(['message' => 'User Updated Successfully'], 201);
    }

    public function destroyUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }


    
}
