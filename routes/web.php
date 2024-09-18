<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


// start main links
// Home ##########
// Route::get('/', [HomepageController::class, 'getHomepage'])->name('getHomepage');

// Login & Sign Up ##########
// Route::get('/login', function () {
//     if (auth()->check()) {
//         return redirect()->route('getHomepage');
//     }
//     return view('user.login');
// })->name('login');
// Route::post('/login', [AuthController::class, 'postSignIn'])->name('postSignIn');
// Route::get('/register', function () {
//     if (auth()->check()) {
//         return redirect()->route('getHomepage');
//     }
//     return view('user.register');
// })->name('register');
// Route::post('/register', [AuthController::class, 'postSignUp'])->name('postSignUp');

// // Login & Sign Up with Redirects ##########
// Route::get('/login2', function () {
//     $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage
//     return view('user.login-redirect', compact('redirect'));
// })->name('login-redirect');
// Route::post('/login2', [AuthController::class, 'postSignInRedirect'])->name('postSignInRedirect');
// Route::get('/register2', function () {
//     $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage
//     return view('user.register-redirect', compact('redirect'));
// })->name('register-redirect');
// Route::post('/register2', [AuthController::class, 'postSignUpRedirect'])->name('postSignUpRedirect');

// // Login & Sign Up with Redirect to Route ##########
// Route::get('/login3', function () {
//     $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage
//     return view('user.login-redirect-route', compact('redirect'));
// })->name('login-redirect-route');

// Route::post('/login3', [AuthController::class, 'postSignInRedirectRoute'])->name('postSignInRedirectRoute');

// Route::get('/register3', function () {
//     $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage
//     return view('user.register-redirect-route', compact('redirect'));
// })->name('register-redirect-route');

// Route::post('/register3', [AuthController::class, 'postSignUpRedirectRoute'])->name('postSignUpRedirectRoute');

// // Login & Sign Up with No Password + Redirect to Route ##########
// Route::get('/login-v4', function () {
//     $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage
//     return view('user.login-redirect-route', compact('redirect'));
// })->name('login-redirect-no-password');

// Route::post('/login-v4', [AuthController::class, 'postSignInRedirectRoute'])->name('postSignInRedirectNoPassword');

// Route::get('/register-v4', function () {
//     $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage
//     $postRoute = request()->input('postRoute');
//     return view('user.register-no-password', compact(['redirect', 'postRoute']));
// })->name('register-redirect-no-password');

// Route::post('/register-v4', [AuthController::class, 'postSignUpRedirectNoPassword'])->name('postSignUpRedirectNoPassword');

// // Log Out
// Route::post('/logout', [AuthController::class, 'postLogout'])->name('postLogout');
// Route::post('/logout2', [AuthController::class, 'postLogoutRedirect'])->name('postLogoutRedirect');
// Route::post('/logout3', [AuthController::class, 'postLogoutRedirectRoute'])->name('postLogoutRedirectRoute');

// // Forgot Password
// Route::get('/forgot', function () {
//     if (auth()->check()) {
//         return redirect()->route('getHomepage');
//     }

//     return view('user.forgot');
// })->name('forgot');
// Route::post('/forgot', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
// Route::get('/resetPassword', function () {
//     return view('user.reset');
// })->name('getResetPassword');
// Route::post('/postResetPassword', [AuthController::class, 'resetPassword'])->name('postResetPassword');

// Route::get('/s', function () {
//     return view('user.edit-profile');
// });


//Route::get('/',[StatisticController::class, 'index'])->name(('index'));

// start auth
Route::get('/login', function () {
    return view('auth.login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// end auth

// start main route

//Route::get('/dashboard', function () {
  //  return view('pages.dashboard');
//})->name('getDashboard');
Route::get('/', [DashboardController::class, 'index'])->name('getDashboard');

Route::prefix('company')->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('getCompany');
    Route::get('/add', [CompanyController::class, 'getAddCompany'])->name('getAddCompany');
    Route::post('/update-grade', [CompanyController::class, 'updateGrade'])->name('update-grade');
    // routes/web.php
    

    // Route::post('/add', [CompanyController::class, 'postAddCompany'])->name('postAddCompany');
    // Route::get('/edit', [CompanyController::class, 'getEditCompany'])->name('getEditCompany');
    // Route::post('/edit', [CompanyController::class, 'postEditCompany'])->name('postEditCompany');
});
// end main route




// Mine
