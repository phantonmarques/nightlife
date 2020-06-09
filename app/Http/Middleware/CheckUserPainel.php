<?php

namespace App\Http\Middleware;

use App\Models\Admin\Establishment;
use Closure;

class CheckUserPainel
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
        // Verify logged
        if ( !auth()->check() )
            return redirect()->route('login');

        if ( auth()->user()->type_user === 'a' || auth()->user()->type_user === 'f' ):
            if ( !empty(auth()->user()->establishment_connect) ):
                if (Establishment::whereStatus(1)->where('id', auth()->user()->establishment_connect)->count() === 0):
                    $user = auth()->user();
                    $user->establishment_connect = null;
                    $user->save();

                endif;
            endif;

        elseif ( auth()->user()->type_user === 'ef' || auth()->user()->type_user === 'e' ):
            if ( (empty(auth()->user()->establishment_connect) || Establishment::whereStatus(1)->where('id', auth()->user()->establishment_connect)->count() === 0) && auth()->user()->type_user === 'ef' ):
                return abort(401);

            elseif (auth()->user()->establishments()->whereStatus(1)->count() === 0 && auth()->user()->type_user === 'e' ):
                return abort(401);

            endif;
        else:
            return abort(401);

        endif;

        return $next($request);
    }
}
