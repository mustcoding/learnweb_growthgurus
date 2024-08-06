<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

//routes to screen

Route::get('/signIn', function () {
    return view('MelakaGo.login');
});

Route::get('/dashboard', function () {
    return view('MelakaGo.dashboard');
});

Route::get('/addStudent', function () {
    return view('MelakaGo.addStudent');
});

Route::get('/sideBar', function () {
    return view('MelakaGo.sideBar');
});

Route::get('/studentManagement', function () {
    return view('MelakaGo.studentManagement');
});

Route::get('/editStudent', function (Illuminate\Http\Request $request) {
    $id = $request->query('id');
    return view('MelakaGo.editStudent', ['id' => $id]);
})->name('/editStudent');


// routes to api

Route::post('login',[UserController::class,'login']);//done

Route::prefix('user')->middleware(['auth:sanctum'])->group(function() {

    Route::post('/findUser', [UserController::class, 'findUser']);//done
    Route::post('/registerUser', [UserController::class, 'register']);//done
    Route::delete('/deleteUser', [UserController::class, 'deleteUser']);
    Route::put('/updateUser', [UserController::class, 'updateUser']);//done
    Route::get('/totalStudent', [UserController::class, 'totalStudent']);//done
    Route::get('/getAllStudents', [UserController::class, 'getAllStudents']);//done

});