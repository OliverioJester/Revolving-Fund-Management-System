<?php

use App\Http\Controllers\AreacustomersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartofaccountsController;
use App\Http\Controllers\ConsolidateController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpensescategoryController;
use App\Http\Controllers\ReportedController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnreportedController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::resource('/consolidates', ConsolidateController::class);
    Route::post('/period-and-transmittal/store', [ConsolidateController::class, 'storePeriodandTransmittal'])->name('consolidates.period_and_transmittal.store');
    Route::put('/period-and-transmittal/{period_and_transmittal}', [ConsolidateController::class, 'updatePeriodandTransmittal'])->name('consolidates.period_and_transmittal.update');
    Route::delete('/consolidates', [ConsolidateController::class, 'bulkDelete'])->name('consolidates.bulk-delete');
    Route::resource('/employees', EmployeeController::class);
    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/area-of-customers', AreacustomersController::class);
    Route::resource('/chart-of-accounts', ChartofaccountsController::class);
    Route::resource('/reported', ReportedController::class);
    Route::resource('/unreported', UnreportedController::class);
    Route::resource('/list', ExpensescategoryController::class);

    // Non-expenses
    Route::get('/list/nonexpenses/create', [ExpensescategoryController::class, 'createNonexpenses'])->name('list.nonexpenses.create');
    Route::post('/list/nonexpenses/store', [ExpensescategoryController::class, 'storenonindex'])->name('list.nonexpenses.store');
    Route::get('/list/nonexpenses/{list}', [ExpensescategoryController::class, 'showNonexpenses'])->name('list.nonexpenses.show');
    Route::get('/list/nonexpenses/{list}/edit', [ExpensescategoryController::class, 'editNonexpenses'])->name('list.nonexpenses.edit');
    Route::put('/list/nonexpenses/{list}', [ExpensescategoryController::class, 'updateNonexpenses'])->name('list.nonexpenses.update');
    Route::delete('/list/nonexpenses/{list}', [ExpensescategoryController::class, 'destroyNonexpenses'])->name('list.nonexpenses.destroy');

});

