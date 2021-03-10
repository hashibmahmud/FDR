<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FDRTableController;
use App\Mail\Verified_FDR;
use App\Models\FDRTable;

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

Route::get('/login', function () {
    if (Auth::check()) {
        return view('dashboard');
    }
    return view('login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::get('/', function () {
    if (Auth::check()) {
        return view('dashboard');
    } else return redirect('login');
});

/*Route::get('/all-fdr', function(){
    return "Hi";
});*/

Route::get('/add-fdr', function () {
    if (Auth::check()) {
        return view('add_fdr');
    }
    return redirect('login');
});

Route::post('/fdr-create', [FDRTableController::class, 'create']);
Route::post('/fdr-edit', [FDRTableController::class, 'update']);
Route::get('/all-fdr', [FDRTableController::class, 'show'])->name('allfdr');
Route::get('/single-fdr/{id}', [FDRTableController::class, 'index'])->name('singlefdr');
Route::get('/fdr-renew/{id}', function ($id) {
    if (Auth::check()) {
        $data = FDRTable::where('id', $id)->get();
        return view('renew-fdr')->with(['data' => $data[0]]);
    }
    return redirect('login');
})->name('renewfdr');
Route::post('/fdr-renew', [FDRTableController::class, 'renew']);
Route::get('/notify', [FDRTableController::class, 'notify']);

Route::get('/pending', function () {
    if (Auth::user()->is_admin != "true") return "Unauthorized";
    $fdrs = FDRTable::where('status', 'pending')->get();
    return view("pending")->with(['fdrs' => $fdrs]);
});
Route::get('/verify/{id}', function ($id) {
    if (Auth::user()->is_admin == "true") {
        $fdr = FDRTable::find($id);
        $fdr->update(['status' => 'verified']);
        Mail::to($fdr->creator)->queue(new Verified_FDR($fdr->fdr_number, $fdr->bank_name, $fdr->branch_name));
        return redirect('/pending');
    } else return "Unauthorized";
})->name('verify');
Route::get('/myfdr', function () {
    if (Auth::check()) {
        $data = FDRTable::where('creator', Auth::user()->email)->get();
        return view('/all-fdr', ['data' => $data, 'source' => 'myfdr']);
    } else return "Unauthorized";
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
