<?php
namespace App\Services\Payments;

class ManualPaymentGateway implements PaymentGatewayInterface
{
    public function createPayment(array $order): array
    {
        return ['status' => 'waiting_payment', 'reference' => $order['invoice'] ?? null];
    }

    public function verify(array $payload): bool { return false; }
}
