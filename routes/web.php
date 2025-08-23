<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\User\FXController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\User\CardController;
use App\Http\Controllers\User\LoanController;
use App\Http\Controllers\User\ViewsController;
use App\Http\Controllers\User\CryptoController;
use App\Http\Controllers\User\PayPalController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TransferController;
use App\Http\Controllers\User\BillPaymentController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;




require __DIR__ . '/admin.php';





//Front Pages Route
Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('terms', [HomePageController::class, 'terms'])->name('terms');
Route::get('privacy', [HomePageController::class, 'privacy'])->name('privacy');
Route::get('about', [HomePageController::class, 'about'])->name('about');
Route::get('contact', [HomePageController::class, 'contact'])->name('contact');
// Route::get('privacy', [HomePageController::class, 'faq'])->name('faq');
Route::get('business', [HomePageController::class, 'business'])->name('business');
Route::get('apps', [HomePageController::class, 'app'])->name('app');
Route::get('loans', [HomePageController::class, 'loans'])->name('loans');
Route::get('send-money', [HomePageController::class, 'loans'])->name('loans');
Route::get('cards', [HomePageController::class, 'cards'])->name('cards');
Route::get('personal', [HomePageController::class, 'personal'])->name('personal');
Route::get('chart', [HomePageController::class, 'personal'])->name('personal');
Route::get('verify', [HomePageController::class, 'verify']);
Route::post('homesendcontact', [HomePageController::class, 'homesendcontact'])->name('homesendcontact');
Route::post('codeverify', [HomePageController::class, 'codeverify'])->name('codeverify');
Route::get('terms-of-service', [HomePageController::class, 'terms'])->name('terms');
Route::get('alerts', [HomePageController::class, 'business'])->name('business');




// Email verification routes
Route::get('/verify-email', 'App\Http\Controllers\User\UsersController@verifyemail')->middleware('auth')->name('verification.notice');;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/ref/{id}', 'App\Http\Controllers\Controller@ref')->name('ref');

/*    Dashboard and user features routes  */
// Views routes
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [ViewsController::class, 'dashboard'])->name('dashboard');




// user routes
Route::middleware(['auth:sanctum', 'verified'])->prefix('dashboard')->group(function () {

    // Verify account route
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/personal-dp', [ProfileController::class, 'uploadProfilePicture'])->name('personal-dp.upload');

    // Transaction routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');

    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit');
    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit');

    // Financial operations
    Route::prefix('deposit')->group(function () {
        Route::get('/', [DepositController::class, 'index'])->name('deposit.index');
        Route::post('/', [DepositController::class, 'store'])->name('deposit.store');
        Route::get('/success', [DepositController::class, 'success'])->name('deposit.success');
    });

    Route::get('/bank', [TransferController::class, 'index'])->name('bank.transfer');

    // Bank Transfer Routes
    Route::prefix('bank-transfer')->name('bank.transfer.')->group(function () {
        Route::get('/', [TransferController::class, 'index'])->name('index');
        Route::post('/store', [TransferController::class, 'transfer'])->name('store');
        Route::get('/confirm', [TransferController::class, 'confirmTransfer'])->name('confirm');
        Route::post('/verify', [TransferController::class, 'verifyTransfer'])->name('verify');
    });


    // FX Trading routes
    Route::prefix('cfx')->group(function () {
        Route::get('/', [FXController::class, 'index'])->name('fx');
        Route::get('/fx-trading', [FXController::class, 'index'])->name('fx.index');
        Route::post('/trades', [FXController::class, 'trade'])->name('trades.store');
        Route::get('/market-data', [FXController::class, 'getMarketData'])->name('market.data');
    });

    // Module-based routes
    Route::prefix('')->group(function () {
        Route::get('/cryptopage', [CryptoController::class, 'crypto'])->name('crypto');
        // Crypto routes
        Route::get('/crypto', [CryptoController::class, 'crypto'])->name('user.crypto');
        Route::get('/crypto/deposit', [CryptoController::class, 'cryptoDepositPage'])->name('user.crypto.deposit.page');
        Route::post('/crypto/deposit', [CryptoController::class, 'cryptoDeposit'])->name('user.crypto.deposit');
        Route::get('/crypto/withdrawal', [CryptoController::class, 'cryptoWithdrawalPage'])->name('user.crypto.withdrawal.page');
        Route::post('/crypto/withdraw', [CryptoController::class, 'processCryptoWithdrawal'])->name('user.crypto.withdraw.submit');
    });

    Route::prefix('loan')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('loan');
        Route::post('/request', [LoanController::class, 'requestLoan'])->name('loan.request');
        Route::get('/history', [LoanController::class, 'history'])->name('loan.history');
    });



    Route::prefix('')->group(function () {
        Route::get('/paybills', [BillPaymentController::class, 'index'])->name('bills.pay');
        Route::get('/bills/pay', [BillPaymentController::class, 'index'])->name('bills.pay');
        Route::post('/bills/process/{type}', [BillPaymentController::class, 'process'])->name('bills.process');
    });

    Route::prefix('paypal')->group(function () {
        Route::get('/paypal', [PayPalController::class, 'index'])->name('paypal');
        // PayPal routes
        Route::get('/', [PayPalController::class, 'paypal'])->name('user.paypal');
        Route::post('/withdraw', [PayPalController::class, 'withdrawToPaypal'])->name('user.paypal.withdraw');
        Route::post('/verify-otp', [PayPalController::class, 'verifyPaypalOtp'])->name('user.paypal.verify-otp');
    });

    Route::prefix('')->group(function () {
        Route::get('/card', [CardController::class, 'index'])->name('card');
        Route::post('/card', [CardController::class, 'store'])->name('card.store');
        Route::post('/card/{card}/toggle-status', [CardController::class, 'toggleStatus'])->name('card.toggle-status');
        Route::delete('/card/{card}', [CardController::class, 'destroy'])->name('card.destroy');
        Route::post('/card-delivery-request', [CardController::class, 'requestDelivery'])->name('card.request-delivery');
    });
});
