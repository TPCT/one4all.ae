<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\TradingViewIndicators;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Service\Service;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndicatorController extends Controller
{
    public function index(){
        if (!auth()->guard('clients')->check())
            return redirect()->route('auth.login');

        $client = auth()->guard('clients')->user();
        $indicator_service = Service::where('view_type', Service::VIEW_TYPE_3)->first();

        if (!$indicator_service)
            throw new NotFoundHttpException();

        if ($indicator_service->paid) {
            $service = $client->services()->where(function ($query) use ($indicator_service) {
                $query
                    ->where('client_services.expires_at', '>', Carbon::today()->toDateString())
                    ->where('client_services.service_id', '=', $indicator_service->id);
            })->first();

            if (!$service) {
                $package = $client->packages()->where(function ($query) {
                    $query->where('client_packages.expires_at', '>', Carbon::today()->toDateString());
                })->first();

                if (!$package || !$package->services->contains($indicator_service->id))
                    return redirect()->route('services.show', ['service' => $indicator_service]);
            }
        }

        $currencies = Currency::active()->get();

        $selected_stamp = request('stamp') ?? __('site.ONE_DAY');
        $currency = $currencies->where('code', request('currency'))->first() ?? $currencies->first();
        $data = TradingViewIndicators::get_data($selected_stamp, $currency->code);

        $moving_averages_signals = TradingViewIndicators::moving_averages($data);
        $oscillators_signals = TradingViewIndicators::oscillators_signal($data);
        $general_signal = TradingViewIndicators::general_signal($data);

        return $this->view('Indicator.index', [
            'selected_stamp' => $selected_stamp,
            'stamps' => [
                __(TradingViewIndicators::FIVE_MINUTES),
                __(TradingViewIndicators::FIFTEEN_MINUTES),
                __(TradingViewIndicators::THIRTY_MINUTES),
                __(TradingViewIndicators::ONE_HOUR),
                __(TradingViewIndicators::TWO_HOURS),
                __(TradingViewIndicators::FOUR_HOURS),
                __(TradingViewIndicators::ONE_DAY),
                __(TradingViewIndicators::ONE_WEEK),
                __(TradingViewIndicators::ONE_MONTH),
            ],
            'currencies' => $currencies,
            'currency' => $currency,
            'general_signal' => TradingViewIndicators::get_corresponding_angle($general_signal['signals'], $general_signal['signal']),
            'moving_averages_signal' =>  TradingViewIndicators::get_corresponding_angle($moving_averages_signals['signals'], $moving_averages_signals['signal']),
            'oscillators_signal' => TradingViewIndicators::get_corresponding_angle($oscillators_signals['signals'], $oscillators_signals['signal']),
        ]);
    }
}
