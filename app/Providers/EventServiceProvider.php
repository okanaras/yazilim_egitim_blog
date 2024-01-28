<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\User;
use App\Events\UserRegistered;
use App\Listeners\SendVerifyEmail;
use App\Models\Category;
use App\Observers\ArticleObserver;
use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Observers\UserRegisteredObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // UserRegistered::class => [
        //     SendVerifyEmail::class,
        // ],
    ];

    protected $observers = [
        User::class => UserRegisteredObserver::class,
        Category::class => CategoryObserver::class,
        Article::class => ArticleObserver::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // User::observe(UserRegisteredObserver::class); ya da yukardaki kullanilabilir.
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
