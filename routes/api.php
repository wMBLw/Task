<?php

use Illuminate\Support\Facades\Route;

Route::GET('get-tasks',[\App\Http\Controllers\TaskController::class,'index']);
Route::POST('add-task',[\App\Http\Controllers\TaskController::class,'store']);
Route::GET('finish-task/{id?}',[\App\Http\Controllers\TaskController::class,'finishTask']);
Route::GET('get-task/{id?}',[\App\Http\Controllers\TaskController::class,'getTask']);
Route::GET('get-data/{status?}',[\App\Http\Controllers\TaskController::class,'getData']);
Route::GET('delete-data/{id?}',[\App\Http\Controllers\TaskController::class,'destroy']);
