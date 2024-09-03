<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubFolderController;
use App\Http\Controllers\ContactListController;
use App\Http\Controllers\ParentFolderController;
use App\Http\Controllers\CityController;

Route::get('/', function () {
    return view('dashboard');
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

});

require __DIR__.'/auth.php';
