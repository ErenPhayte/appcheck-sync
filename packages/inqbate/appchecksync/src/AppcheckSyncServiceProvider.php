<?php
/**
 * @filesource AppcheckSyncServiceProvider.php
 * @author Foo Bar <foo.bar@email.com>
 * @version    Release: AppcheckSyncServiceProvider
 * Date: 2020/03/05
 * Time: 10:01
 */

namespace Inqbate\AppcheckSync;


use Illuminate\Support\ServiceProvider;

class AppcheckSyncServiceProvider extends ServiceProvider
{
    public function register()
    {
        /**
         * $this->app->singleton(DeezerProvider::class, function ($app) {
                    $provider = new DeezerProvider([
                    'clientId'     => config('MusicProviders.deezer.client_id'),
                    'clientSecret' => config('MusicProviders.deezer.secret'),
                    'redirectUri'  => config('MusicProviders.deezer.redirect_uri'),
                    ]);

                    if($provider->hasToken()) {
                    $token = $provider->getStoredToken();
                    $provider->setToken($token);
                    }
                    return $provider;

            });
         */
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath($raw = __DIR__ . '/../config/appchecksync.php') ?: $raw;
        $this->publishes([$source => config_path('appchecksync.php')]);
        $this->mergeConfigFrom($source, 'AppcheckSync');
    }
}
