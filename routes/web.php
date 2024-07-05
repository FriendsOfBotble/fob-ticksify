<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Theme\Facades\Theme;
use FriendsOfBotble\Ticksify\Http\Controllers\CategoryController;
use FriendsOfBotble\Ticksify\Http\Controllers\Fronts\TicketController as FrontTicketController;
use FriendsOfBotble\Ticksify\Http\Controllers\TicketController;

AdminHelper::registerRoutes(function () {
    Route::prefix('ticksify')->name('fob-ticksify.')->group(function () {
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::resource('', CategoryController::class)->parameters(['' => 'category']);
        });

        Route::group(['prefix' => 'tickets', 'as' => 'tickets.'], function () {
            Route::resource('', TicketController::class)
                ->except(['create', 'store'])
                ->parameters(['' => 'ticket']);
        });
    });
});

Theme::registerRoutes(function () {
    Route::middleware('customer')
        ->prefix('ticksify/tickets')
        ->name('fob-ticksify.public.tickets.')
        ->group(function () {
            Route::get('/', [FrontTicketController::class, 'index'])->name('index');
            Route::get('create', [FrontTicketController::class, 'create'])->name('create');
            Route::post('/', [FrontTicketController::class, 'store'])->name('store');
            Route::get('{ticket}', [FrontTicketController::class, 'show'])->name('show');
        });
});
