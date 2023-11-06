<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    public function login(Request $request)
    {
        $loginField = $request->input('login');
        $password = $request->input('password');
        $field = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $field => $loginField,
            'password' => $password,
        ];
        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $tokenResult = $user->createToken('auth-token');
            $token = $tokenResult->accessToken;
            return response()->json([
                'user' => $user, 
                'accessToken' => $token], 200);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
   
    public function self()
    {
        $user = User::find(auth()->user()->id);
        // $token = $user->createToken('authToken')->accessToken;
        return response(['user' => $user]);
    }
   
   
    public function createUser(Request $request)
    {
        $request->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            'role' => 'required|in:user,admin,super_admin',
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $userData = $request->only([
            'lastname', 'firstname', 'address', 'contact', 'role', 'username', 'email', 'password'
        ]);

        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->update($request->only([
            'lastname', 'firstname', 'address', 'contact', 'username', 'email',
        ]));

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
    public function toggleActivation($id)
    {
        $user = User::findOrFail($id);
        $activate = !$user->is_active;
        $user->update(['is_active' => $activate]);
        $action = $activate ? 'activated' : 'deactivated';
        return response()->json(['message' => "User $action successfully", 'user' => $user]);
    }

    public function viewAllUser(Request $request) {
        {
            $perPage = $request->input('per_page', 10); 
            $sortBy = $request->input('sort_by', 'id');
            $sortDesc = $request->input('sort_desc', false); 
            $filter = $request->input('filter', '');
        
            $query = User::where('role', 'user')->orderBy($sortBy, $sortDesc ? 'desc' : 'asc');
        
            if ($filter) {
                $query->where(function ($q) use ($filter) {
                    $q->where('lastname', 'like', "%$filter%")
                        ->orWhere('firstname', 'like', "%$filter%")
                        ->orWhere('address', 'like', "%$filter%")
                        ->orWhere('email', 'like', "%$filter%")
                        ->orWhere('contact', 'like', "%$filter%");
                });
            }
        
            $users = $query->paginate($perPage);
            return response()->json(['users' => $users], 200);
        }
    }

    public function test () {
        $logMessage = "This is a test log message.";
        error_log($logMessage);
    }

    public function tokenRefresher (Request $request) {
        $token = $request->user()->token();
        $token->revoke(); // Revoke the current token
    
        $newToken = $request->user()->createToken('auth-token');
    
        return response()->json([
            'accessToken' => $newToken->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => now()->addSeconds($newToken->token->expires_at->timestamp)->format('Y-m-d H:i:s'),
        ]);
    }

}
