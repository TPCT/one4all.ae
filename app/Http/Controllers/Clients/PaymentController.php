<?php

namespace App\Http\Controllers\Clients;

use App\Models\ClientConsultation;
use App\Models\Package\Package;
use App\Models\Service\Service;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal;

class PaymentController
{
    private function process_service_transaction(Service $service, $response, $reference_id){
        if (isset($response['id']) && $response['id']) {
            $consultation = ClientConsultation::where('id', $reference_id)
                ->where('paid', 0)
                ->whereNull('payment_id')
                ->first();
            if ($consultation)
                $consultation->update([
                    'payment_id' => $response['id'],
                ]);

            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve')
                    return redirect()->away($link['href']);
            }
        }

        return redirect()->route('services.show', ['service' => $service])->with('service', __("site.Something went wrong"));
    }

    public function process_package_transaction(Package $package, $response){
        if (isset($response['id']) && $response['id']) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve')
                    return redirect()->away($link['href']);
            }
        }
        return redirect()->route('site.index')->with('package', __("site.Something went wrong"));
    }

    public function success_service_transaction(Service $service, $response){
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            if ($service->view_type == Service::VIEW_TYPE_2) {
                ClientConsultation::where('payment_id', $response['id'])->update([
                    'paid' => 1
                ]);
            }else{
                $client = auth()->guard('clients')->user();
                $client->services()->attach($service->id, [
                    'expires_at' => Carbon::today()->addMonths(1),
                ]);
            }
            return redirect()
                ->route('services.show', ['service' => $service])
                ->with('success', 'Transaction complete.');
        }
        return redirect()->route('services.show', ['service' => $service])->with('service', __("site.Something went wrong"));
    }

    public function success_package_transaction(Package $package, $response){
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $client = auth()->guard('clients')->user();
            $client->packages()->attach($package->id, [
                'expires_at' => Carbon::today()->addMonths($package->months),
            ]);
            return redirect()
                ->route('site.index')
                ->with('success', 'Transaction complete.');
        }
        return redirect()->route('site.index')->with('package', __("site.Something went wrong"));
    }

    public function process_transaction($locale, $type, $model){
        $model = $type == "services" ? Service::whereSlug($model)->firstOrFail() : Package::findOrFail($model);

        if (!auth()->guard('clients')->check())
            return redirect()->route('auth.login');

        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('payment.success', ['model' => $model, 'type' => $type]),
                'cancel_url' => route('payment.failed', ['model' => $model, 'type' => $type]),
            ],
            "purchase_units" => [
                [
                    'amount' => [
                        'value' => (string) $model->price,
                        'currency_code' => 'USD'
                    ],
                ]
            ]
        ]);

        switch ($type) {
            case "services":
                return $this->process_service_transaction($model, $response, request('reference_id'));
            case "packages":
                return $this->process_package_transaction($model, $response);
            default:
                return redirect()->route('site.index')->with('package', __("site.Something went wrong"));
        }
    }

    /**
     * @throws \Throwable
     */
    public function success_transaction($locale, $type, $model){
        $provider = new payPal();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder(\request('token'));

        switch ($type) {
            case "services":
                $model = Service::whereSlug($model)->firstOrFail();
                return $this->success_service_transaction($model, $response);
            case "packages":
                $model = Package::whereSlug($model)->firstOrFail();
                return $this->success_package_transaction($model, $response);
            default:
                return redirect()->route('site.index')->with('package', __("site.Something went wrong"));
        }
    }

    public function failed_transaction($locale, $type, $model){
        if ($type == "services")
            return redirect()->route('services.show', ['service' => $model])->with('service', __("site.Something went wrong"));
        return redirect()->route('site.index')->with('package', __("site.Something went wrong"));
    }
}