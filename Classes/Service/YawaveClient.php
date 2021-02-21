<?php


namespace Yawave\Yawave\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Yawave\Yawave\Service\ErrorMessage;

class YawaveClient
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * Abstract constructor.
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl)
    {
        $this->httpClient =  new Client(['base_uri' => $baseUrl]);
        $this->baseUrl = $baseUrl;

    }

    /**
     * @param string|null $clientId
     * @param string|null $secret
     * @return $this
     * @throws GuzzleException
     */
    public function authorize(string $clientId = null, string $secret = null)
    {

        $data = $this->call('POST', 'token', [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $secret,
        ]);

        $this->accessToken = $data['access_token'];

        return $this;
    }

    /**
     * @param string $endpoint
     * @param array $queryParams
     * @return string
     */
    private function buildUri(string $endpoint, array $queryParams = []): string
    {
        $queryString = [] !== $queryParams ? '?' . http_build_query($queryParams) : '';
        return $this->baseUrl . '/' . $endpoint . $queryString;
    }

    /**
     * @param string $method
     * @param string $endPoint
     * @param array $body
     * @param array $queryParams
     * @return array|string|null
     * @throws GuzzleException
     */
    private function call(string $method, string $endPoint, array $body = [], array $queryParams = [])
    {
        $options = [
            'headers' => [
                'Authorization' => 'bearer ' . $this->accessToken,
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'allow_redirects' => false,
        ];

        if ([] !== $body)
        {
            $options['form_params'] = $body;
        }
        $uri = $this->buildUri($endPoint, $queryParams);


        try {
            $response = $this->httpClient->request($method, $uri, $options);
        }catch (ClientException $e){
            $code = $e->getResponse()->getStatusCode();
            if($code === 400){
                $body = 'You do not have account on '.$uri;
                $header = 'Configuration';
                return (new ErrorMessage())->showError($header,$body);
            }
        }






        $contents = $response->getBody()->getContents();
        if(null !== $decodedJson = json_decode($contents, true)){

            return $decodedJson;
        }

        return [];
    }

    /**
     * @param string $endPoint
     * @param array $queryParams
     * @return array|string|null
     * @throws GuzzleException
     */
    public function get(string $endPoint, array $queryParams = [])
    {
        return $this->call('GET', $endPoint, [], $queryParams);
    }


    /**
     * @param string $endPoint
     * @param array $body
     * @param array $queryParams
     * @return array|string|null
     * @throws GuzzleException
     */
    public function post(string $endPoint, array $body = [], array $queryParams = [])
    {
        return $this->call('POST', $endPoint, $body, $queryParams);
    }

    /**
     * @param string $accessToken
     * @return YawaveClient
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

}