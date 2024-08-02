<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function login(Request $request)
    {
        // Validate fields
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Attempt login
        if (!Auth::attempt($attrs)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 403);
        }

        // Return user & token in response
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }

    public function register(Request $request)
    {
        // Validate fields
        $attrs = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string|max:255'
        ]);

        // Create user
        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => Hash::make($attrs['password']),
            'address' => $attrs['address']
        ]);

        // Return user & token in response
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 201);
    }

    public function deleteUser(Request $request)
    {
        $id = $request->input('studentId');
        // Find user by ID
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        // Delete user
        $user->delete();

        // Return response
        return response()->json([
            'message' => 'User deleted successfully.'
        ], 200);
    }

    public function updateUser(Request $request)
    {
        $id = $request->input('studentId');

        Log::info('Request data: ' . json_encode($request->all()));
        // Validate the request data
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'address' => 'sometimes|required|string|max:255'
        ]);

        // Retrieve the user by ID
        $user = User::find($id);

        Log::info('user   ' . $user);
        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update the user's attributes only if they are present in the request
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('address')) {
            $user->address = $request->input('address');
        }

        // Save the changes to the database
        $user->save();

        // Return a success response
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function totalStudent()
    {
        $totalStudents = User::count();
        return response()->json(['totalStudents' => $totalStudents], 200);
    }

    public function getAllStudents()
    {
        // Retrieve all students (users)
        $students = User::all();

        // Return the list of students
        return response()->json([
            'students' => $students
        ], 200);
    }

    public function findUser(Request $request)
    {
        $id = $request->input('studentId');
        // Find user by ID
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        // Return response
        return response()->json([
            'student' => $user,
        ], 200);
    }
}
