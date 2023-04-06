<?php

use App\Http\Controllers\Api\{CompanyController, EmployeeController, ResponsibilityController, RoleController, TeamController, UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {

    // authentication
    Route::prefix('auth')->group(function () {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/register', [UserController::class, 'register']);
    });

    // get with token sanctum
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::get('/user', [UserController::class, 'fetchUser']);
        // company
        Route::prefix('company')->group(function () {
            Route::get('', [CompanyController::class, 'getAll']); // all Data
            Route::post('', [CompanyController::class, 'create']); // create Data
            Route::post('update/{companyId}', [CompanyController::class, 'update']); // update Data
        });
        // team
        Route::prefix('team')->group(function () {
            Route::get('', [TeamController::class, 'getAll']); // all Data
            Route::post('', [TeamController::class, 'create']); // create Data
            Route::post('update/{teamId}', [TeamController::class, 'update']); // update Data
            Route::delete('{teamId}', [TeamController::class, 'destroy']); // destory Data
        });
        // role
        Route::prefix('role')->group(function () {
            Route::get('', [RoleController::class, 'getAll']); // all Data
            Route::post('', [RoleController::class, 'create']); // create Data
            Route::post('update/{roleId}', [RoleController::class, 'update']); // update Data
            Route::delete('{roleId}', [RoleController::class, 'destroy']); // destory Data
        });
        // responsibility
        Route::prefix('responsibility')->group(function () {
            Route::get('', [ResponsibilityController::class, 'getAll']); // all Data
            Route::post('', [ResponsibilityController::class, 'create']); // create Data
            Route::post('update/{responsibilityId}', [ResponsibilityController::class, 'update']); // update Data
            Route::delete('{responsibilityId}', [ResponsibilityController::class, 'destroy']); // destory Data
        });
        // employee
        Route::prefix('employee')->group(function () {
            Route::get('', [EmployeeController::class, 'getAll']); // all Data
            Route::post('', [EmployeeController::class, 'create']); // create Data
            Route::post('update/{employeeId}', [EmployeeController::class, 'update']); // update Data
            Route::delete('{employeeId}', [EmployeeController::class, 'destroy']); // destory Data
        });
    });
});
