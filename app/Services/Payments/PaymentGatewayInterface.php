<?php
namespace App\Services\Payments;

interface PaymentGatewayInterface
{
    public function createPayment(array $order): array;
    public function verify(array $payload): bool;
}
