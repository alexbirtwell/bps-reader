<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/in/{key}', function (Request $request, $key) {
    if ($key !== env('SECURE_KEY')) {
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    $body = $request->get('body');
    \App\Models\Reading::create([
        'raw' => $body
    ]);
    return view('welcome');
});
