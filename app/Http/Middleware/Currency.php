<?php
namespace App\Http\Middleware;
use Closure;
class Currency
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currency = ($request->hasHeader('X-currency')) ? $request->header('X-currency') : 'sar';

        session()->put('currency',$currency);

        return $next($request);
    }
}
