<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */

namespace Inqbate\Unfuddle;

use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;

abstract class UnfuddleAbstract
{
    /**
     * @var string
     */
    protected $id;

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
     * @return UnfuddleAbstract
     */
    public function setRequestUri(string $requestUri): UnfuddleAbstract
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
     * @return UnfuddleAbstract
     */
    private function setRequestBody(array $data): UnfuddleAbstract
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
     * @return UnfuddleAbstract
     */
    private function setRequestHeaders(array $headers): UnfuddleAbstract
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
     * @return UnfuddleAbstract
     */
    private function setResponseBody($body): UnfuddleAbstract
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
     * @return UnfuddleAbstract
     */
    private function setResponseHeaders(array $headers): UnfuddleAbstract
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    protected function setId(string $id): void
    {
        $this->id = $id;
    }


    /**
     * Get data from endpoint
     *
     * @param array $data
     * @return UnfuddleAbstract
     */
    public function get(array $data = []): UnfuddleAbstract
    {
        return $this->fetch('GET', $data);

    }

    /**
     * Post data to endpoint
     *
     * @param array $data
     * @return UnfuddleAbstract
     */
    public function post(array $data): UnfuddleAbstract
    {
        return $this->fetch('POST', $data);
    }

    /**
     * Update data at an endpoint
     *
     * @param array $data
     * @return UnfuddleAbstract
     */
    public function put(array $data): UnfuddleAbstract
    {
        return $this->fetch('PUT', $data);
    }

    /**
     * Delete data from an endpoint
     *
     * @param array $data
     * @return UnfuddleAbstract
     */
    public function delete(array $data = []): UnfuddleAbstract
    {
        return $this->fetch('DELETE', $data);
    }


    /**
     * Handles all requests types
     * @param string $method
     * @param array $data
     * @return UnfuddleAbstract
     */
    private function fetch(string $method = 'GET', array $data = []): UnfuddleAbstract {

      //  return $this->debug();
        $method = strtoupper($method);
        $client = new GuzzleHttp\Client();
        $endpoint = $this->baseUrl . $this->getRequestUri();

        $this->setRequestHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $this->setRequestBody($data);

        $key = 'query';

        if($method != 'GET' || $method != 'DELETE') {
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
        dump($debug);
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
