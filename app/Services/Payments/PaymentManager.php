<?php
namespace App\Services\Payments;

class PaymentManager
{
    public function gateway(): PaymentGatewayInterface
    {
        return match (config('payment.mode')) {
            'manual' => app(ManualPaymentGateway::class),
            default => app(ManualPaymentGateway::class),
        };
    }
}
