<?php

use App\Models\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\ErrorHandler\Debug;

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

Route::middleware(['cors'])->post('/in/{key}', function (Request $request, $key) {
    if ($key !== env('SECURE_KEY')) {
        return response()->json(['error' => 'Invalid API key'], 401);
    }

    $data = explode($request->get('body'), '|');
    foreach($data as $d) {
        $reading = json_decode($d);
        $created[] = Reading::create([
            'raw' => $d,
            'source_id' => data_get($reading, 'sourceId', ''),
            'value' => data_get($reading, 'value', ''),
            'sourceTimestamp' => data_get($reading, 'sourceTimestamp', null),
        ]);
    }

    return response()->json(['success' => true, 'created' => collect($created)->pluck('id')->toArray()]);
});
