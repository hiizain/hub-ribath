<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\back\ProgramController as BackProgram;
use App\Http\Controllers\back\LayananController as BackLayanan;
use App\Http\Controllers\user\ProgramController as UserProgram;
use App\Http\Controllers\ProgramController as Program;
use App\Http\Controllers\LayananController as Layanan;
use App\Http\Controllers\LoginController as Login;
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

Route::resource('back/program', BackProgram::class, ['as' => "back"]);
Route::get('back/seleksi', [BackProgram::class, 'seleksi'])->name('back.program.seleksi');
Route::get('back/seleksi/{idProgram}', [BackProgram::class, 'seleksiShow'])->name('back.program.seleksi.show');
Route::get('back/program/detail/{idProgram}', [BackProgram::class, 'detail'])->name('back.program.detail');
Route::post('back/program/{idProgram}', [BackProgram::class, 'update']);
Route::post('back/program/date-tahap-program/{idProgram}', [BackProgram::class, 'updateDateTahapProgram']);

Route::get('back/layanan/sewa', [BackLayanan::class, 'sewa'])->name('back.layanan.sewa');
Route::post('back/layanan/sewa/aksi', [BackLayanan::class, 'aksiSewa'])->name('back.layanan.sewa.aksi');
Route::get('back/layanan/safari', [BackLayanan::class, 'safari'])->name('back.layanan.safari');
Route::post('back/layanan/safari/aksi', [BackLayanan::class, 'aksiSafari'])->name('back.layanan.safari.aksi');

Route::get('layanan/sewa', [Layanan::class, 'sewa'])->name('layanan.sewa');
Route::post('layanan/sewa', [Layanan::class, 'aksiSewa'])->name('layanan.sewa.aksi');
Route::post('layanan/sewa/cek', [Layanan::class, 'cekSewa'])->name('layanan.sewa.cek');
Route::post('layanan/sewa/cek-tanggal', [Layanan::class, 'cekSewaTanggal'])->name('layanan.sewa.cek-tanggal');
Route::get('layanan/safari', [Layanan::class, 'safari'])->name('layanan.safari');
Route::post('layanan/safari', [Layanan::class, 'aksiSafari'])->name('layanan.safari.aksi');
Route::post('layanan/safari/cek', [Layanan::class, 'cekSafari'])->name('layanan.safari.cek');
Route::post('layanan/safari/cek-tanggal', [Layanan::class, 'cekSafariTanggal'])->name('layanan.safari.cek-tanggal');

// Route::resource('program', Program::class);
Route::get('program', [Program::class, 'index'])->name('program.index');
Route::get('program/daftar', [Program::class, 'pendaftaran'])->name('program.daftar');
Route::post('program/daftar', [Program::class, 'pendaftaranAction'])->name('program.daftar.action');

Route::get('user/dashboard', function () {
    return view('user/dashboard');
})->name('user.dashboard');
Route::get('user/program', [UserProgram::class, 'index'])->name('user.program.index');
Route::get('user/program/detail/{idProgram}', [UserProgram::class, 'detail'])->name('user.program.detail');

Route::get('login', [Login::class, 'login'])->name('login');
Route::post('login', [Login::class, 'authenticate'])->name('authenticate');
Route::get('register', [Login::class, 'register'])->name('register');
Route::post('register', [Login::class, 'registerAction'])->name('registerAction');
Route::get('logout', [Login::class, 'logout'])->name('logout');

// Route::get('/auth', function () {
//     return view('login');
// });

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('welcome');
// });
