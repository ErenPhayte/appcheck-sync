<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */

namespace Inqbate\Appcheck;

use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;

abstract class AppcheckAbstract
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $apiString = 'api/v1/';

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $requestUri;
    /**
     * @var string
     */
    protected $requestBody;
    /**
     * @var array
     */
    protected $requestHeaders = [];
    /**
     * @var array
     */
    protected $responseHeaders = [];
    /**
     * @var array
     */
    protected $responseBody;

    /**
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->baseUrl = $this->connection->getEndpoint() . $this->apiString . $this->connection->getApiKey() . '/';
    }

    /**
     * Set the request URI
     * @param string $requestUri
     * @return AppcheckAbstract
     */
    public function setRequestUri(string $requestUri): AppcheckAbstract
    {
        $this->requestUri = $requestUri;
        return $this;
    }

    /**
     * Get the request URI
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     * Set the request body
     * @param array $data
     * @return AppcheckAbstract
     */
    public function setRequestBody(array $data): AppcheckAbstract
    {
        $this->requestBody = json_encode($data);
        return $this;
    }

    /**
     * Get the request body
     * @return string $data
     */
    public function getRequestBodyRaw(): ?string
    {
        return $this->requestBody;
    }

    /**
     * Get the request body
     * @return array $data
     */
    public function getRequestBody(): ?array
    {
        return json_decode($this->requestBody) ?? null;
    }

    /**
     * Set the request headers
     * @param array $headers
     * @return AppcheckAbstract
     */
    public function setRequestHeaders(array $headers): AppcheckAbstract
    {
        $this->requestHeaders = $headers;
        return $this;
    }

    /**
     * Get the request headers
     * @return array
     */
    public function getRequestHeaders(): array
    {
        return $this->requestHeaders;
    }

    /**
     * Get the response body as a json string
     * @return string
     */
    public function getResponseBodyRaw(): string
    {
        return json_encode($this->responseBody);
    }

    /**
     * Get the response body
     * @return array
     */
    public function getResponseBody(): ?array
    {
        return $this->responseBody ?? null;
    }

    /**
     * Set the response body
     * @param string|array $body
     * @return AppcheckAbstract
     */
    public function setResponseBody($body): AppcheckAbstract
    {
        if(is_string($body)) {
            $this->responseBody = json_decode($body, true) ?? null;
        } else {
            $this->responseBody = $body;
        }
        return $this;
    }

    /**
     * Set the response headers
     * @param array $headers
     * @return AppcheckAbstract
     */
    public function setResponseHeaders(array $headers): AppcheckAbstract
    {
        $this->responseHeaders = $headers;
        return $this;
    }

    /**
     * Get the response headers
     * @return array
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * Get data from endpoint
     *
     * @param array $data
     * @return AppcheckAbstract
     */
    public function get(array $data): AppcheckAbstract
    {
        return $this->fetch('GET', $data);

    }

    /**
     * Post data to endpoint
     *
     * @param array $data
     * @return AppcheckAbstract
     */
    public function post(array $data): AppcheckAbstract
    {
        return $this->fetch('POST', $data);
    }


    /**
     * Handles both GET and POST requests
     * @param string $method
     * @param array $data
     * @return AppcheckAbstract
     */
    private function fetch(string $method = 'GET', array $data = []): AppcheckAbstract {

        $client = new GuzzleHttp\Client();
        $endpoint = $this->baseUrl . $this->getRequestUri();

        $this->setRequestHeaders([
            'Accept' => 'application/json',
            'Accept-Encoding' => 'identity'
        ]);

        $this->setRequestBody($data);

        $key = 'query';

        if($method = 'POST') {
            $key = 'json';
        }

        try {
            $res = $client->request($method, $endpoint, [
                'headers' => $this->getRequestHeaders(),
                $key =>  $this->getRequestBody()
            ]);

            $this->setResponseHeaders($res->getHeaders());
            $this->setResponseBody((string) $res->getBody());

        } catch(ClientException $e) {

            $this->setResponseHeaders($e->getResponse()->getHeaders());
            $this->setResponseBody((string) $e->getResponse()->getBody());

            $this->setResponseBody(array_merge($this->getResponseBody(), ['success' => false]));

        } finally {

            return $this;
        }

    }

    /**
     * Returns request and response headers and body as well as endpoint for debugging.
     *
     * @return object
     */
    public function debug(): object
    {
        $endpoint = $this->baseUrl . $this->getRequestUri();
        $debug = [
            'endpoint' => $endpoint,
            'request' => [
                'body' => $this->getRequestBody(),
                'headers' => $this->getRequestHeaders()
            ],
            'response' => [
                'body' => $this->getResponseBody(),
                'headers' => $this->getResponseHeaders()
            ]
        ];
        return (object) $debug;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        $data = $this->getResponseBody();
        if(array_key_exists($name, $data)) {
            return $data[$name];
        }
        throw new \UnexpectedValueException('Undefined property $' . $name);
    }

    /**
     * Returns the error object
     * @return array|null
     */
    public function getError():?array {
        if($this->success === false) {
            $data = $this->getResponseBody();
            unset($data['success']);
            return $data;
        }
    }

}
