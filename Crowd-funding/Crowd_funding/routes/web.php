<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Add_FundController;
use App\Http\Controllers\Frontend\Donation_detailsController;
use App\Http\Controllers\Frontend\Make_DonationController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/add_fund', [Add_FundController::class, 'showForm'])->name('addFund');
Route::post('/add_fund', [Add_FundController::class, 'store']);


Route::get('/donation_details/{id}', [Donation_detailsController::class, 'show']);

Route::post('/Donate', [Make_DonationController::class, 'store'])->name('donate');
