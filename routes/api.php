<?php

use App\Http\Controllers\Api\SparepartApiController; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route; 
 
Route::get('/spareparts', [SparepartApiController::class, 'index']);