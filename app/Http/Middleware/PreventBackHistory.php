<?php

    namespace App\Http\Middleware;

    use Closure;

    class PreventBackHistory{
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next){
            $response = $next($request);
            if(method_exists($response, 'header'))
            {
                $response->header('Access-Control-Allow-Origin' , '*')
                       ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                       ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
            }

            return $response;
        }
    }
