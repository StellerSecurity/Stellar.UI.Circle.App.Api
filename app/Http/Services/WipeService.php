<?php

namespace App\Http\Services;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;


class WipeService
{

    private $baseUrl = "https://stellerphonewipeapiprod.azurewebsites.net/api/";

    private $usernameKey = "APPSETTING_API_USERNAME_STELLER_PHONE_WIPE_API";

    private $passwordKey = "APPSETTING_API_PASSWORD_STELLER_PHONE_WIPE_API";

    /**
     * @param string $auth_token
     * @return PromiseInterface|Response
     */
    public function findbytoken(string $auth_token): PromiseInterface|Response
    {
        $response = Http::withBasicAuth(getenv($this->usernameKey),getenv($this->passwordKey))
            ->get($this->baseUrl . "V1/wipeusercontroller/findbytoken?auth_token=" . $auth_token);
        return $response;
    }

    public function patch(array $data): PromiseInterface|Response
    {
        $response = Http::withBasicAuth(getenv($this->usernameKey),getenv($this->passwordKey))
            ->patch($this->baseUrl . "v1/wipeusercontroller/patch", $data);
        return $response;
    }


}
