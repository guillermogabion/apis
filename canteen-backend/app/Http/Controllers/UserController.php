<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Routing\Controller;
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
                'accessToken' => $token,
            ], 200);
        } else {
            // Check specific errors
            $errorMessage = 'Username or password is incorrect.';
            $errorCode = 'INVALID_CREDENTIALS';
    
            if (!User::where($field, $loginField)->exists()) {
                $errorMessage = ucfirst($field) . ' not found';
                $errorCode = 'USER_NOT_FOUND';
            } elseif (!User::where($field, $loginField)->where('password', bcrypt($password))->exists()) {
                $errorMessage = 'Username or password is incorrect.';
                $errorCode = 'INCORRECT_PASSWORD';
            }
    
            return response()->json([
                'error' => [
                    'description' => 'Invalid Credentials',
                    'errorCode' => $errorCode,
                    'message' => $errorMessage
                ]
            ], 200);
        }
    }


//     public function login(Request $request)
// {
//     $loginField = $request->input('login');
//     $password = $request->input('password');
//     $field = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
//     $credentials = [
//         $field => $loginField,
//         'password' => $password,
//     ];

//     if (Auth::attempt($credentials)) {
//         $user = auth()->user();
//         $tokenResult = $user->createToken('auth-token', ['*']);
//         $token = $tokenResult->accessToken;

//         // Retrieve the refresh token from the database
//         $refreshToken = RefreshToken::where('access_token_id', $tokenResult->token->id)->first();

//         // Check if refresh token is found
//         if ($refreshToken) {
//             // Use the 'CreateFreshApiToken' middleware to generate a new access token
//             // $request->session()->regenerate();
//             $request->headers->set('Authorization', 'Bearer ' . $token);

//             return response()->json([
//                 'user' => $user,
//                 'accessToken' => $token,
//                 'refreshToken' => $refreshToken->id,
//             ], 200);
//         } else {
//             // Handle the case where refresh token is not found
//             return response()->json([
//                 'error' => [
//                     'description' => 'Refresh token not found',
//                     'errorCode' => 'REFRESH_TOKEN_NOT_FOUND',
//                     'message' => 'Unable to retrieve refresh token.'
//                 ]
//             ], 500);
//         }
//     } else {
//         // Handle invalid credentials
//         return response()->json([
//             'error' => [
//                 'description' => 'Invalid Credentials',
//                 'errorCode' => 'INVALID_CREDENTIALS',
//                 'message' => 'Username or password is incorrect.'
//             ]
//         ], 200);
//     }
// }
    
    
    

   
public function self()
{
    $user = User::with('store')->find(auth()->user()->id);

    // Access the 'store' relationship data
    $storeData = $user->store;
    
    // Return the response with user and store data
    return response(['user' => $user]);
}
   
   
    public function createUser(Request $request)
    {
        $request->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            // 'role' => 'required|in:user,admin,super_admin',
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $userData = $request->only([
            'lastname', 'firstname', 'address', 'contact', 'username', 'email', 'password'
        ]);

        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    // public function updateUser(Request $request)
    // {
    //     $user = Auth::user();
    
    //     $request->validate([
    //         'lastname' => 'string',
    //         'firstname' => 'string',
    //         'address' => 'string',
    //         // 'contact' => 'required|string',
    //         'username' => 'string',
    //         'email' => 'email|unique:users,email,' . $user->id,
    //         'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);
    
    //     $user->update($request->only([
    //         'lastname', 'firstname', 'address', 'contact', 'username', 'email', 'photo',
    //     ]));
    
       
    //     if ($request->hasFile('photo')) {
    //         $file = $request->file('photo');
    //         $fileName = time() . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('uploads'), $fileName);
    
    //         // Update the user's photo field in the database
    //         $user->photo = $fileName;
    //     }
    //     $user->save();
    //     return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    // }

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $data = User::find($user->id);
        $requestData = $request->all();

        // Update user fields
        $data->update(array_filter($requestData));

        // Handle photo upload if a file is provided
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);

            // Update the user's photo field in the database
            $data->photo = $fileName;
            $data->save();
        }

        return response()->json(['message' => 'User updated successfully', 'user' => $data]);
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
