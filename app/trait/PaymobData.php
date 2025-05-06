<?php

namespace App\trait;
use Illuminate\Support\Facades\Http;

use App\Models\PaymentMethodAuto;

trait PaymobData
{
    private static $instance = null;
    private $config = [];

    private function __construct()
    {
        $this->loadFromDatabase();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadFromDatabase()
    {
        $settings = PaymentMethodAuto::
        where('payment_method_id', 1)
        ->first();

        $this->config = [
            'PAYMOB_API_KEY' => env('PAYMOB_API_KEY'),
            'PAYMOB_SECRET_TOKEN' =>  env('PAYMOB_SECRET_TOKEN'),
            'PAYMOB_IFRAME_ID' =>  env('PAYMOB_IFRAME_ID'),
            'PAYMOB_INTEGRATION_ID' =>  env('PAYMOB_INTEGRATION_ID'),
            'PAYMOB_HMAC' =>  env('PAYMOB_HMAC'),
        ];
    }

    public function get($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    public function refresh()
    {
        $this->loadFromDatabase();
    }
}
