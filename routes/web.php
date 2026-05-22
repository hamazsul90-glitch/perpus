<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard', [
        'booksCount' => Book::count(),
        'membersCount' => Member::count(),
        'activeLoansCount' => Loan::whereNull('returned_at')->count(),
    ]);
})->name('home');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('books', BookController::class)->except(['show']);
Route::resource('members', MemberController::class)->except(['show']);
Route::get('members/{member}', [MemberController::class, 'show'])->name('members.show');
Route::get('loans', [LoanController::class, 'index'])->name('loans.index');
Route::get('loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('loans', [LoanController::class, 'store'])->name('loans.store');
Route::get('loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
Route::post('loans/{loan}/return', [LoanController::class, 'markReturned'])->name('loans.return');

// admin exports & reports
Route::get('admin/export/books', [\App\Http\Controllers\AdminExportController::class, 'exportBooks'])->name('admin.export.books');
Route::get('admin/export/loans', [\App\Http\Controllers\AdminExportController::class, 'exportLoans'])->name('admin.export.loans');

Route::get('admin/reports/monthly-loans', [\App\Http\Controllers\AdminReportController::class, 'monthlyLoans'])->name('admin.reports.monthly_loans');
Route::get('admin/reports/member-delinquency', [\App\Http\Controllers\AdminReportController::class, 'memberDelinquency'])->name('admin.reports.member_delinquency');

// Loan policy & payments (admin)
Route::get('admin/loan-policy', [\App\Http\Controllers\Admin\LoanPolicyController::class, 'edit'])->name('admin.loan_policy.edit');
Route::put('admin/loan-policy', [\App\Http\Controllers\Admin\LoanPolicyController::class, 'update'])->name('admin.loan_policy.update');

Route::get('admin/cashier', [\App\Http\Controllers\Admin\CashierController::class, 'index'])->name('admin.cashier.index');

Route::get('admin/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');
Route::get('admin/payments/create/{loan}', [\App\Http\Controllers\Admin\PaymentController::class, 'createForLoan'])->name('admin.payments.create');
Route::post('admin/payments/store/{loan}', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('admin.payments.store');
Route::post('admin/payments/{payment}/mark-paid', [\App\Http\Controllers\Admin\PaymentController::class, 'markPaid'])->name('admin.payments.markPaid');
