<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PayMongoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.paymongo.com/v1/',
            'auth' => [config('services.paymongo.secret'), '']
        ]);
    }

    public function createGCashSource($amountInCentavos)
    {
        try {
            $response = $this->client->post('sources', [
                'json' => [
                    'data' => [
                        'attributes' => [
                            'amount' => $amountInCentavos,
                            'currency' => 'PHP',
                            'type' => 'gcash',
                            'redirect' => [
                                'success' => route('payment.success'),
                                'failed' => route('payment.failed'),
                            ]
                        ]
                    ]
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('PayMongo GCash Source Error: ' . $e->getMessage());
            return null;
        }
    }
}
