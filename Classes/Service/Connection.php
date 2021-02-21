<?php


namespace Yawave\Yawave\Service;

use Yawave\Yawave\Service\YawaveClient;
use Yawave\Yawave\Service\YawaveApi;


class Connection
{

    /**
     * @param string $clientId
     * @param string $secret
     * @param string $domin
     * @return string
     */
    public function apiConnection(string $clientId, string $secret, string $domin) {

        $authApi = (new YawaveClient('https://sso.'.$domin.'/auth/realms/yawave/protocol/openid-connect'))->authorize($clientId, $secret);

        $clientApi = (new YawaveClient('https://api.'.$domin.''));

        $clientApi->setAccessToken($authApi->getAccessToken());

        $client = new YawaveApi($clientApi);

        $applicationId = $client->applicationId();

        $result = [
            'client' => $client,
            'applicationId' => $applicationId
        ];

        return $result;
    }
}