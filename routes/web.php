<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubFolderController;
use App\Http\Controllers\ContactListController;
use App\Http\Controllers\ParentFolderController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GroupController;

Route::get('/', function () {
    return redirect()->route('parentFolder.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

    // Group Routes
    Route::resource('groups', GroupController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware(['auth', 'verified']);

    // Campaign Routes
    Route::resource('campaigns', CampaignController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'addReceipient', 'storeReceipient'])
        ->middleware(['auth', 'verified']);

    // Specific routes for creating subfolders and contact lists under parent folders
    Route::get('/parent-folders/{parentFolder}/sub-folders/create', [SubFolderController::class, 'create'])->name('subFolder.create');
    Route::get('/sub-folders/{subFolder}/contact-lists/create', [ContactListController::class, 'create'])->name('contactList.create');
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

    // Add Group Contact route
    Route::post('/groups/{group}/addGroupContact', [GroupController::class, 'addGroupContact'])->name('groups.addGroupContact');

    // add campaign in the receipient's module
    Route::get('campaigns/{campaign}/addReceipient', [CampaignController::class, 'addReceipient'])->name('campaigns.addReceipient');
    Route::post('campaigns/{campaign}/storeReceipient', [CampaignController::class, 'storeReceipient'])->name('campaigns.storeReceipient');

    // show campaign details
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');

    // Delete receipients
    Route::delete('/campaigns/{campaign}/deleteReceipient/{receipient}', [CampaignController::class, 'deleteReceipient'])->name('campaigns.deleteReceipient');

});

require __DIR__.'/auth.php';
