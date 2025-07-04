<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubFolderController;
use App\Http\Controllers\ContactListController;
use App\Http\Controllers\ParentFolderController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\RecipientController;
use Illuminate\Support\Facades\Mail;
use jdavidbakr\MailTracker\MailTrackerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;

Route::get('/', function () {
    return redirect()->route('parentFolder.index');
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Remove Comment to access Material Dashboard
    //Route::get('profile', [ProfileController::class, 'create'])->name('profile');

    // ParentFolder routes with search functionality
    Route::resource('parentFolder', ParentFolderController::class)
        ->only(['index', 'create', 'show', 'store', 'edit', 'update', 'destroy'])
        ->middleware('verified');

    // SubFolder routes
    Route::resource('subFolder', SubFolderController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('verified');

    // ContactList routes
    Route::resource('contactList', ContactListController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('verified');



    // Specific routes for creating subfolders and contact lists under parent folders
    Route::get('/parent-folders/{parentFolder}/sub-folders/create', [SubFolderController::class, 'create'])->name('subFolder.create');
    Route::get('/sub-folders/{subFolder?}/contact-lists/create', [ContactListController::class, 'create'])->name('contactList.create');
    Route::get('/contactList/{contactList}/edit', [ContactListController::class, 'edit'])->name('contactList.edit');
    Route::put('/contactList/{contactList}', [ContactListController::class, 'update'])->name('contactList.update');

    // Category and Contact routes
    Route::resource('category', CategoryController::class);
    Route::resource('contact', ContactController::class);

    Route::get('/contact', [ContactController::class, 'index']);
    Route::get('/contact/children/{parentId}', [ContactController::class, 'getChildFolders']);
    Route::get('/contact/sub', [ContactController::class, 'subIndex']);
    Route::get('/api/cities', [CityController::class, 'fetchCities']);

    // Export/Import Contact Lists
    Route::get('export-contact-lists', [ContactListController::class, 'export']);
    Route::post('import-contact-lists', [ContactListController::class, 'import'])->name('contactList.import');

    // Extra Contact List route
    Route::get('/contact-list', [ContactListController::class, 'index'])->name('contactList.index');

    Route::post('/contacts/mass_edit', [ContactListController::class, 'massEdit'])->name('contacts.mass_edit');

    Route::post('campaigns/{campaign}/send', [CampaignController::class, 'sendCampaign'])->name('campaigns.send');

    Route::get('/send-email', function () {
        $subject = 'Your Campaign Subject';
        $htmlContent = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Email Template</title>
            <style>
                /* Your inline styles */
            </style>
        </head>
        <body>
            <h1>This is your email content</h1>
        </body>
        </html>';

        // Send the email
        Mail::html($htmlContent, function ($message) use ($subject) {
            $message->to('insaneraj08@gmail.com')  // Change this to the recipient's email
                    ->subject($subject); // Use the campaign's subject
        });

    return 'Email sent successfully!';

    });

    Route::post('/delete-multiple', [ContactListController::class, 'deleteMultiple'])->name('contacts.deleteMultiple');
    Route::get('/contact-list/template', [ContactListController::class, 'downloadTemplate'])->name('contactList.downloadTemplate');

    Route::resource('campaigns', CampaignController::class);

    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns/{campaign}/send', [CampaignController::class, 'sendCampaign'])->name('campaigns.send');
    Route::get('/send-campaign/{id}', [CampaignController::class, 'sendCampaignEmail']);
    Route::get('/campaign/{id}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaigns.update');
    Route::post('/campaigns/{campaign}/send-all', [CampaignController::class, 'sendToAll'])->name('campaigns.sendAll');
    Route::post('/recipients', [RecipientController::class, 'store'])->name('recipients.store');
    Route::post('/campaigns/{campaign}/add-recipient', [RecipientController::class, 'addRecipient'])->name('campaigns.addRecipient');
    Route::post('/campaigns/{campaign}/schedule', [CampaignController::class, 'schedule'])->name('campaigns.schedule');
    Route::post('/campaigns/{campaign}/duplicate', [CampaignController::class, 'duplicate'])->name('campaigns.duplicate');
    Route::delete('/campaigns/{campaign}/deleteRecipient/{recipient}', [CampaignController::class, 'deleteReceipient'])->name('campaigns.deleteRecipient');
    Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');

    Route::get('/email-templates', [EmailTemplateController::class, 'index'])->name('email_templates.index');
    Route::get('/email-templates/create', [EmailTemplateController::class, 'create'])->name('email_templates.create');
    Route::post('/email-templates', [EmailTemplateController::class, 'store'])->name('email_templates.store');

    Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
    Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
    Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
    Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
    Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
    Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
    Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
    Route::get('verify', function () {
        return view('sessions.password.verify');
    })->middleware('guest')->name('verify');
    Route::get('/reset-password/{token}', function ($token) {
        return view('sessions.password.reset', ['token' => $token]);
    })->middleware('guest')->name('password.reset');

    Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
    Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('billing', function () {
            return view('pages.billing');
        })->name('billing');
        Route::get('tables', function () {
            return view('pages.tables');
        })->name('tables');
        Route::get('rtl', function () {
            return view('pages.rtl');
        })->name('rtl');
        Route::get('virtual-reality', function () {
            return view('pages.virtual-reality');
        })->name('virtual-reality');
        Route::get('notifications', function () {
            return view('pages.notifications');
        })->name('notifications');
        Route::get('static-sign-in', function () {
            return view('pages.static-sign-in');
        })->name('static-sign-in');
        Route::get('static-sign-up', function () {
            return view('pages.static-sign-up');
        })->name('static-sign-up');
        Route::get('user-management', function () {
            return view('pages.laravel-examples.user-management');
        })->name('user-management');
        Route::get('user-profile', function () {
            return view('pages.laravel-examples.user-profile');
        })->name('user-profile');
    });


});

require __DIR__.'/auth.php';




