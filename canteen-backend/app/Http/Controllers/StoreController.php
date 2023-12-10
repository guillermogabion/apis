<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function createStore(Request $request)
    {
        $validatedData = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'required|string|max:255',
        ]);
    
        $storeData = array_merge($validatedData, ['user_id' => Auth::user()->id]);
    
        Store::create($storeData);
    
        return response()->json(['message' => 'Store created successfully'], 201);
    }

}
