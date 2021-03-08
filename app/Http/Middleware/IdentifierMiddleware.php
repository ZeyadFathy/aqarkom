<?php

namespace App\Http\Middleware;

use Closure;

class IdentifierMiddleware
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
		$request->request->add( [ 'user_id' => app( 'auth' )->guard()->user()->id ] );

		return $next( $request );    }
}
