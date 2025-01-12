<?php

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

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\MapAuthController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\RubbishController;
use App\Http\Controllers\SiwaController;
use App\Http\Controllers\Web\ConversationController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EntryController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\HelpController;
use App\Http\Controllers\Web\LandingPageController;
use App\Http\Controllers\Web\LegalController;
use App\Http\Controllers\Web\OrganisationController;
use App\Http\Controllers\Web\ParkingAreaController;
use App\Http\Controllers\Web\ProfileController;


Route::group(['middleware' => ['guest']], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout'])->name('logout.seamless');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/login/apple', [SiwaController::class, 'login']);
Route::post('/login/apple/callback', [SiwaController::class, 'callback']);

Route::get('/login/google', [GoogleController::class, 'login']);
Route::post('/login/google/callback', [GoogleController::class, 'callback']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.attempt');

Route::get('/maps/auth', [MapAuthController::class, 'token']);

Route::get('language/{language}', function ($language) {
    Session()->put('locale', $language);
    return redirect()->back();
})->name('language');

Route::get('/home', HomeController::class)->name('home');
Route::get('/abfallkalender', [RubbishController::class, 'index'])->name('rubbish.index');
Route::get('/abfallkalender/{street}', [RubbishController::class, 'show'])->name('rubbish.show');
Route::get('/parken/{slug}', [ParkingAreaController::class, 'show'])->name('parking-area.show');
Route::get('/parken', [ParkingAreaController::class, 'index'])->name('parking-area.index');
Route::get('/kraftstoff', [FuelController::class, 'index'])->name('petrol.index');
Route::get('/neuigkeiten', [NewsController::class, 'index'])->name('news.index');

Route::group([], function () {

    Route::get('/', LandingPageController::class)->name('landingPage');

    Route::get('/veranstaltungen', [EventController::class, 'index'])->name('events.index');
    Route::get('/veranstaltungen/{event}', [EventController::class, 'show'])->name('events.show');

    Route::redirect('/android', 'https://play.google.com/store/apps/details?id=com.lambdadigamma.moers', 301);
    Route::redirect('/ios', 'https://apps.apple.com/de/app/mein-moers/id1305862555?mt=8', 301);

    Route::get('/app', [MarketingController::class, 'app'])->name('marketing.app');

    Route::middleware(['auth'])->group(function () {
        Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        Route::get('/profile', [ProfileController::class, 'details'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'updateInformation'])->name('profile.update');
        Route::post('/profile/export', [ProfileController::class, 'exportData'])->name('profile.export');
        Route::delete('/profile', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
    });

    Route::get('/legal/privacy', [LegalController::class, 'privacy'])->name('legal.privacy');
    Route::get('/legal/imprint', [LegalController::class, 'imprint'])->name('legal.imprint');
    Route::get('/legal/tac', [LegalController::class, 'tac'])->name('legal.tac');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/help', [HelpController::class, 'index'])->name('help.index');
    Route::get('/help/serve', [HelpController::class, 'serve'])->name('help.serve');
    Route::get('/help/need', [HelpController::class, 'need'])->name('help.need')->middleware('auth');
    Route::post('/help/need', [HelpController::class, 'sendHelpRequest'])->name('help.need.store')->middleware('auth');
    Route::get('/help/request/{helpRequest}', [HelpController::class, 'helpRequest'])->name('help.request.show')->middleware('auth');
    Route::delete('/help/request/{helpRequest}', [HelpController::class, 'deleteHelpRequest'])->name('help.request.delete')->middleware(['auth']);
    Route::put('/help/request/{helpRequest}/accept', [HelpController::class, 'acceptHelpRequest'])->name('help.request.accept')->middleware(['auth']);
    Route::post('/help/request/{helpRequest}/messages', [HelpController::class, 'sendMessage'])->name('help.request.sendMessage')->middleware(['auth']);
    Route::post('/help/request/{helpRequest}/done', [HelpController::class, 'done'])->name('help.request.done')->middleware(['auth']);
    Route::post('/help/request/{helpRequest}/quit', [HelpController::class, 'quitHelpRequest'])->name('help.request.quit')->middleware(['auth']);

    Route::get('/organisations/{organisation}', [OrganisationController::class, 'show'])->name('organisations.show');
    Route::get('/organisations/{organisation}/events/{event}', [OrganisationController::class, 'event'])->name('organisations.event.show');

    Route::post('/conversations/{conversation}/readMessage', [ConversationController::class, 'sendReadMessage'])->name('conversations.readMessage')->middleware(['auth']);

    Route::get('/entries/{selectedEntry?}', [EntryController::class, 'index'])->name('entries.index');

    Route::personalDataExports('personal-data-exports');

});

