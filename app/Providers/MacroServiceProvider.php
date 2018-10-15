<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        EloquentBuilder::macro('cursorPaginate', function ($limit, $cursor, $order = 'asc') {
            return $this
                ->lampager()
                ->limit($limit)
                ->orderBy('id', $order)
                ->seekable()
                ->paginate($cursor);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
