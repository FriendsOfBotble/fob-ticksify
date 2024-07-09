<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Theme\Facades\Theme;
use FriendsOfBotble\Ticksify\Http\Controllers\CategoryController;
use FriendsOfBotble\Ticksify\Http\Controllers\Fronts\TicketController as FrontTicketController;
use FriendsOfBotble\Ticksify\Http\Controllers\Fronts\TicketMessageController as FrontTicketMessageController;
use FriendsOfBotble\Ticksify\Http\Controllers\MessageController;
use FriendsOfBotble\Ticksify\Http\Controllers\TicketController;
use FriendsOfBotble\Ticksify\Http\Controllers\TicketMessageController;

AdminHelper::registerRoutes(function () {
    Route::prefix('ticksify')->name('fob-ticksify.')->group(function () {
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::resource('', CategoryController::class)->parameters(['' => 'category']);
        });

        Route::group(['prefix' => 'tickets', 'as' => 'tickets.'], function () {
            Route::match(['GET', 'POST'], '/', [TicketController::class, 'index'])->name('index');
            Route::get('{ticket}', [TicketController::class, 'show'])->name('show');
            Route::post('{ticket}/messages', [TicketMessageController::class, 'store'])->name('messages.store');
            Route::post('{ticket}', [TicketController::class, 'update'])->name('update');
            Route::delete('{ticket}', [TicketController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('messages')->name('messages.')->group(function () {
            Route::resource('', MessageController::class)
                ->except(['create', 'store'])
                ->parameters(['' => 'message']);
        });
    });
});

Theme::registerRoutes(function () {
    Route::middleware(is_plugin_active('ecommerce') ? 'customer' : 'account')
        ->prefix('tickets')
        ->name('fob-ticksify.public.tickets.')
        ->group(function () {
            Route::get('/', [FrontTicketController::class, 'index'])->name('index');
            Route::get('create', [FrontTicketController::class, 'create'])->name('create');
            Route::post('/', [FrontTicketController::class, 'store'])->name('store');
            Route::get('{ticket}', [FrontTicketController::class, 'show'])->name('show');
            Route::post('{ticket}/messages', [FrontTicketMessageController::class, 'store'])->name('messages.store');
        });
});
