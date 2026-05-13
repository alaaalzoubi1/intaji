<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\AppUsageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GamificationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\TipController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Auth — public
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('register'); // FR-01
        Route::post('login',    [AuthController::class, 'login']);    // FR-02
    });

    // Protected
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::prefix('auth')->group(function () {
            Route::post('logout',      [AuthController::class, 'logout']);
            Route::get('me',           [AuthController::class, 'me']);
            Route::put('profile',      [AuthController::class, 'updateProfile']);   // FR-04
            Route::post('personality', [AuthController::class, 'savePersonality']); // FR-05
        });

        // Sections & Activities
        Route::get('sections',                          [ActivityController::class, 'sections']);
        Route::get('sections/{section}/activities',     [ActivityController::class, 'sectionActivities']);
        Route::get('activities/today',                  [ActivityController::class, 'todayActivities']);   // FR-09
        Route::put('activities/{activity}/settings',    [ActivityController::class, 'updateSettings']);    // FR-11

        // Activity Logs
        Route::get('logs',              [ActivityLogController::class, 'index']);     // FR-08
        Route::post('logs',             [ActivityLogController::class, 'store']);     // FR-06
        Route::get('logs/calendar',     [ActivityLogController::class, 'calendar']); // FR-08
        Route::get('logs/{log}',        [ActivityLogController::class, 'show']);
        Route::put('logs/{log}',        [ActivityLogController::class, 'update']);   // FR-07
        Route::delete('logs/{log}',     [ActivityLogController::class, 'destroy']);  // FR-07

        // Statistics
        Route::prefix('stats')->group(function () {
            Route::get('overview',            [StatsController::class, 'overview']);      // FR-23
            Route::get('sections',            [StatsController::class, 'sectionStats']);  // FR-23
            Route::get('activity/{activity}', [StatsController::class, 'activityStats']); // FR-19, FR-20
            Route::get('compare',             [StatsController::class, 'compare']);       // FR-21
            Route::get('correlations',        [StatsController::class, 'correlations']);  // FR-22
        });

        // App Usage
        Route::prefix('app-usage')->group(function () {
            Route::post('sync',       [AppUsageController::class, 'sync']);        // FR-14, FR-15
            Route::get('report',      [AppUsageController::class, 'report']);      // FR-15, FR-24
            Route::get('correlation', [AppUsageController::class, 'correlation']); // FR-16
            Route::get('limits',      [AppUsageController::class, 'getLimits']);
            Route::post('limits',     [AppUsageController::class, 'setLimit']);    // FR-17
        });

        // Tips
        Route::prefix('tips')->group(function () {
            Route::get('today',           [TipController::class, 'today']);    // FR-25, FR-27
            Route::get('history',         [TipController::class, 'history']);
            Route::post('{tip}/feedback', [TipController::class, 'feedback']); // FR-26
        });

        // Gamification
        Route::prefix('gamification')->group(function () {
            Route::get('badges',     [GamificationController::class, 'badges']);     // FR-29
            Route::get('tree',       [GamificationController::class, 'tree']);       // FR-30
            Route::get('points',     [GamificationController::class, 'points']);     // FR-28
            Route::get('challenges', [GamificationController::class, 'challenges']); // FR-32
        });

        // Store
        Route::prefix('store')->group(function () {
            Route::get('/',                  [GamificationController::class, 'store']);
            Route::post('{item}/purchase',   [GamificationController::class, 'purchase']); // FR-31
            Route::post('{item}/activate',   [GamificationController::class, 'activate']);
        });

        // Notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/',                       [NotificationController::class, 'index']);
            Route::get('unread-count',            [NotificationController::class, 'unreadCount']);
            Route::post('read-all',               [NotificationController::class, 'markAllRead']);
            Route::post('{notification}/read',    [NotificationController::class, 'markRead']);
        });
    });
});
