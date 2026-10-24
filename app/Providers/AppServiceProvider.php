<?php

namespace App\Providers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::before(fn (User $user) => $user->isSuperAdmin() ? true : null);

        $this->configureLocalization();
        $this->configureModelStrictness();
        $this->configureDatabase();
        $this->configureDates();
        $this->configureUrls();
    }

    protected function isProduction(): bool
    {
        return $this->app->environment('production');
    }

    protected function configureLocalization(): void
    {
        Number::useLocale(config()->string('app.locale'));
        Number::useCurrency(config()->string('app.currency'));

        // ...
    }

    protected function configureModelStrictness(): void
    {
        Model::automaticallyEagerLoadRelationships();
        Model::shouldBeStrict(! $this->isProduction());
    }

    protected function configureDatabase(): void
    {
        DB::prohibitDestructiveCommands($this->isProduction());
    }

    protected function configureUrls(): void
    {
        URL::forceHttps($this->isProduction());
    }

    protected function configureDates(): void
    {
        Date::use(CarbonImmutable::class); // avoids accidental mutation bugs

        Carbon::macro(
            'default',
            fn (string $format = 'd M, Y') => $this
                ->locale(app()->getLocale())
                ->translatedFormat($format)
        );
    }
}
