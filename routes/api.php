<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TahapController;
use App\Http\Controllers\Api\KegiatanController;
use App\Http\Controllers\Api\TahapProgramController;
use App\Http\Controllers\Api\KegiatanProgramController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('kegiatan', KegiatanController::class,['as'=> "api"]);

Route::apiResource('kegiatan-program', KegiatanProgramController::class,['as'=> "api"]);
Route::get('kegiatan-program/by_program/{idProgram}', [KegiatanProgramController::class, 'showByProgram'])->name('api.kegiatan-program.by_program');

Route::apiResource('tahap', TahapController::class,['as'=> "api"]);

Route::apiResource('tahap-program', TahapProgramController::class,['as'=> "api"]);
Route::get('tahap-program/by_program/{idProgram}', [TahapProgramController::class, 'showByProgram'])->name('api.tahap-program.by_program');

