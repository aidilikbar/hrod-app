<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrgChartController;

Route::get('/orgchart', [OrgChartController::class, 'index']);
Route::post('/orgchart', [OrgChartController::class, 'store']);
Route::put('/orgchart/{id}', [OrgChartController::class, 'update']);
Route::delete('/orgchart/{id}', [OrgChartController::class, 'destroy']);