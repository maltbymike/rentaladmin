<?php

namespace App\Providers;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;
use Filament\Forms\Components\DateTimePicker;
use SebastianBergmann\Type\VoidType;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() :void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DateTimePicker::configureUsing(fn (DateTimePicker $component) => $component->timezone('America/Toronto'));
        TextColumn::configureUsing(fn (TextColumn $column) => $column->timezone('America/Toronto'));
    }
}
