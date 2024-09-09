<?php

namespace Massterski\DmMarkirovka;

use GuzzleHttp\Client;
use Massterski\DmMarkirovka\Models\ApiToken;
use Illuminate\Support\Facades\Log;

class ApiClient
{
    protected $client;
    protected $baseUri;

    public function __construct($baseUri)
    {
        $this->client = new Client();
        $this->baseUri = $baseUri;
    }

    public function authenticate($credentials)
    {
        $response = $this->client->post($this->baseUri . 'apiUot/api/v1/private/get-token', [
            'json' => $credentials,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        $token = ApiToken::updateOrCreate(
            ['service' => "ismet"], // Сохраняем один токен и обновляем его
            [
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_at' => now()->addSeconds($data['expires_in']),
            ]
        );

        return $token;
    }

    public function refreshToken()
    {
        $token = ApiToken::where('service', '=','ismet')->first();

        if ($token && $token->isExpired()) {
            $response = $this->client->get($this->baseUri . 'apiUot/api/v1/private/refresh-token', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Refresh-Token' => $token->refresh_token,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            $token->updateToken($data['access_token'], $data['refresh_token'], $data['expires_in']);

            return $token;
        }

        return $token;
    }

    public function getDocumentList($organizationBin)
    {
        $token = $this->refreshToken();

        $response = $this->client->post($this->baseUri . 'apiUot/api/v1/private/doc-list', [
            'headers' => [
                'Authorization' => $token->access_token,
                'Content-Type' => 'application/json',
                'Innbin' => $organizationBin,
                'Commoditygroup' => 'pharma',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function checkDataMatrix($organizationBin, $data)
    {
        $token = $this->refreshToken();

        $response = $this->client->post($this->baseUri . 'apiUot/api/v1/private/code-comparison', [
            'headers' => [
                'Authorization' => $token->access_token,
                'Content-Type' => 'application/json',
                'Innbin' => $organizationBin,
                'Commoditygroup' => 'pharma',
            ],
            'json' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getDocumentProfile($data)
    {
        $token = $this->refreshToken();

        $response = $this->client->post($this->baseUri . 'apiUot/api/v2/private/profile-doc', [
            'headers' => [
                'Authorization' => $token->access_token,
                'Content-Type' => 'application/json'
            ],
            'json' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getDocumentDataMatrixs($documentId, $organizationBin, $data)
    {
        $token = $this->refreshToken();

        $response = $this->client->post($this->baseUri . 'apiUot/api/v2/private/document/codes/'.$documentId, [
            'headers' => [
                'Authorization' => $token->access_token,
                'Content-Type' => 'application/json',
                'Innbin' => $organizationBin,
                'Commoditygroup' => 'pharma',
            ],
            'json' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

  public function getDocumentId($organizationBin, $data)
  {
    $token = $this->refreshToken();

    $response = $this->client->post($this->baseUri . 'apiUot/api/v1/private/info-km', [
      'headers' => [
        'Authorization' => $token->access_token,
        'Content-Type' => 'application/json'
      ],
      'json' => $data
    ]);

    return json_decode($response->getBody(), true);
  }
}
