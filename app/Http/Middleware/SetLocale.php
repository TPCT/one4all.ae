<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->segment(1), [
            'livewire', 'admin', 'storage'
        ]))
            return $next($request);

        $locale = $request->segment(1);
        if (!in_array($locale, array_keys(config('app.locales')))){
            $locale = session('locale', config('app.locale'));
            return redirect('/' . $locale . "/" . $request->path());
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);
        \URL::defaults(['locale' => $locale]);

        if ($request->get('fallbackPlaceholder'))
            return redirect('/' . $request->get('fallbackPlaceholder'));
        return $next($request);
    }
}
