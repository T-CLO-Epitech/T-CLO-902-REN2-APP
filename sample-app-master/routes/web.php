<?php

use App\Models\Counter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $value = Counter::sum('count');
    return view('welcome', ['value' => $value]);
});

Route::get('/healthz', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/readyz', function () {
    try {
        DB::select('SELECT 1');

        if (!Schema::hasTable('counters')) {
            return response()->json(['status' => 'waiting-for-migrations'], 503);
        }

        return response()->json(['status' => 'ready']);
    } catch (\Throwable $exception) {
        return response()->json(['status' => 'db-unavailable'], 503);
    }
});
