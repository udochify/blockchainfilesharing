<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlockchainController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ShareController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', [FileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'nocache'])->group(function () {
    Route::get('/share/check', [ShareController::class, 'check'])->name('share.check');
    Route::get('/contacts/error', [ContactController::class, 'error'])->name('contacts.error');
    Route::get('/files/error', [FileController::class, 'error'])->name('files.error');
    Route::post('/files/delete/{file}', [FileController::class, 'delete'])->name('files.delete');
    Route::post('/files/download/{file}', [FileController::class, 'download'])->name('files.download');
    Route::post('/files/share/{file}', [ShareController::class, 'share'])->name('files.share');
    Route::post('/files/unshare/{file}', [ShareController::class, 'unshare'])->name('files.unshare');
    Route::post('/files/unshare_reverse/{file}', [ShareController::class, 'unshare_reverse'])->name('files.unshare_reverse');
    Route::post('/blockchain/register', [BlockchainController::class, 'register'])->name('blockchain.register');
});

Route::middleware('auth')->group(function () {
    Route::resource('files', FileController::class)->only(['index', 'store'])
        ->names(['index'=>'files.index', 'store'=>'files.upload']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('contacts', ContactController::class)->only(['index', 'store'])
        ->names(['index'=>'contact.index', 'store'=>'contact.add']);
    Route::get('/email/send', [EmailController::class, 'send'])->name('email.send');
});

require __DIR__.'/auth.php';
