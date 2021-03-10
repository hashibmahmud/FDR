<?php

use App\Models\FDRTable;
use App\Models\Instrument;
use App\Models\Notification;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::delete('/fdr/{id}', function ($id) {
    FDRTable::find($id)->delete();
    Signatory::where('fdr_id', $id)->delete();
    $files = Instrument::where('fdr_id', $id)->get();
    foreach ($files as $key => $value) {
        File::delete('uploads/' . $value['new_file_name']);
    }
    Instrument::where('fdr_id', $id)->delete();
    Notification::where('fdr_id', $id)->delete();
    return 200;
});
