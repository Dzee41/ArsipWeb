<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice\{
    ManagementAccountController,
    ManagementArchiveController,
};
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/edit-profile',  [ManagementAccountController::class, 'managementAccount'])->name('edit-profile');
Route::view('/forgot-password', 'backoffice.manage_accounts.forgot_password')->name('forgot_password');
Route::put('/edit-profile/{id}', [ManagementAccountController::class, 'update'])->name('edit_profile.update');
Route::get('/change-password',  [ManagementAccountController::class, 'managementAccount'])->name('change_password');
Route::post('change-password', [ManagementAccountController::class, 'changePassword'])->name('change-password.changePassword');
Route::get('/users-index', [ManagementAccountController::class, 'userIndex'])->name('users-index');
Route::view('/create-user', 'backoffice.manage_accounts.create_user')->name('create-user');
Route::post('/change-status', [ManagementAccountController::class, 'changeAccountStatus'])->name('change-status');
Route::get('/edit-user-profile/{id}', [ManagementAccountController::class, 'editUserProfile'])->name('edit-user-profile');
Route::put('/update-user-profile/{id}', [ManagementAccountController::class, 'updateUserProfile'])->name('update-user-profile');
Route::post('/change-role', [ManagementAccountController::class, 'changeRole'])->name('change-role');
Route::delete('/delete-user/{id}', [ManagementAccountController::class, 'destoryUser'])->name('delete-user');
Route::post('/generate-new-user', [ManagementAccountController::class, 'newUserStore'])->name('generate-new-user');
Route::get('/categories', [ManagementArchiveController::class, 'categoryIndex'])->name('categories');
Route::post('/categories', [ManagementArchiveController::class, 'categoryStore'])->name('categories.categoryStore');
Route::post('/category-update', [ManagementArchiveController::class, 'categoryUpdate'])->name('category-update.categoryUpdate');
Route::delete('/category-delete/{id}', [ManagementArchiveController::class, 'categoryDestroy'])->name('category-delete');
Route::get('/archives/{id}', [ManagementArchiveController::class, 'archivesIndex'])->name('archives');

// MANAGEMENT DOCS
// Route::get('/archive/{id}', [ManagementArchiveController::class, 'archiveShow'])->name('archive');
Route::get('/documents', [ManagementArchiveController::class, 'archivesIndexAll'])->name('documents.archivesIndexAll');
Route::get('/documents/{id}', [ManagementArchiveController::class, 'archiveShow'])->name('documents.archiveShow');
Route::get('tab-archives', [ManagementArchiveController::class, 'tabArchives'])->name('tab-archives');
Route::get('new-document/{id}', [ManagementArchiveController::class, 'createDocument'])->name('new-document');
Route::post('store-document/{id}', [ManagementArchiveController::class, 'storeDocument'])->name('store-document.storeDocument');
// Arsip
Route::get('/download/{file}', [ManagementArchiveController::class, 'download'])->name('file.download');
// Route::get('/edit-archive/{id}', [ManagementArchiveController::class, 'editArchive'])->name('edit-archive.editArchive');
Route::get('/documents/{id}/category', [ManagementArchiveController::class, 'editArchive'])->name('edit-archive.editArchive');
Route::post('/update-archive', [ManagementArchiveController::class, 'updateArchive'])->name('update-archive.updateArchive');
Route::delete('/destroy-archive/{id}', [ManagementArchiveController::class, 'destroyArchive'])->name('destroy-archive.destroyArchive');


Route::get('/preview/pdf/{file}', [ManagementArchiveController::class, 'previewPdf'])->name('file.preview.pdf');
