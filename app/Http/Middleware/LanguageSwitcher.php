<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the route is an API route
        if ($request->is('api/*')) {
            // Check if the 'Accept-Language' header is present in the request
            if ($request->header('Accept-Language')) {
                $locale = $request->header('Accept-Language');
            } else {
                // If no 'Accept-Language' header is found, fallback to default locale
                $locale = Config::get('app.locale');
            }

            // Validate the locale
            $supportedLocales = array_column(Config::get('app.supported_locales'), 'code');
            // Check if the selected locale is in the supported locales
            if (in_array($locale, $supportedLocales)) {
                Session::put('locale', $locale); // Store the locale in session
            } else {
                $locale = Config::get('app.locale'); // Set default locale if not supported
            }

            App::setLocale($locale); // Set the application locale for API request
        }
        else{ //if ($request->has('locale')) {
            $locale = $request->get('locale');

            // Validate the locale
            // Get the supported locales from the configuration
            $supportedLocales = array_column(Config::get('app.supported_locales'), 'code');
            // Check if the selected locale is in the supported locales
            if (in_array($locale, $supportedLocales)) {
                Session::put('locale', $locale); // Store the locale in session
            }else{
                $locale = Config::get('app.locale');
            }
            App::setLocale($locale); // Set the application locale
        }
        // If no locale in session, use default
        if (!Session::has('locale')) {
            Session::put('locale', Config::get('app.locale'));
        }
        // Set the application locale
        App::setLocale(Session::get('locale'));
        return $next($request);
    }
}
