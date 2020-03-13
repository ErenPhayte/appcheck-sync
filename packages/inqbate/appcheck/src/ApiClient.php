<?php
/**
 * @filesource ApiClient.php
 * @author Foo Bar <foo.bar@email.com>
 * @version    Release: ApiClient
 * Date: 2020/03/10
 * Time: 14:08
 */

namespace Inqbate\Appcheck;


use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use http\Exception\InvalidArgumentException;
use Inqbate\Appcheck\Exceptions\ApiModelNotFoundException;

/**
 *
 * @property bool $success
 * @package    Inqbate\Appcheck
 * @copyright  2020 InQBate part of Quint Group
 */
class ApiClient
{
    /**
     * @var Connection
     */
    protected static $connection;

    /**
     * @var string
     */
    protected static $apiString = 'api/v1/';

    /**
     * @var string
     */
    protected $baseUrl= '';

    /**
     * @var string
     */
    protected $requestUri = '';
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
     * @var int
     */
    protected $statusCode = 0;
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
        self::$connection = $connection;
        $this->baseUrl = $connection->getEndpoint() . self::$apiString . $connection->getApiKey() . '/';
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    private function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Set the request URI
     * @param string $requestUri
     * @return ApiClient
     */
    public function setRequestUri(string $requestUri): ApiClient
    {
        $this->requestUri = $requestUri;
        return $this;
    }

    /**
     * Get the request URI
     * @return string|null
     */
    public function getRequestUri(): ?string
    {
        return $this->requestUri;
    }

    /**
     * Set the request body
     * @param array $data
     * @return ApiClient
     */
    private function setRequestBody(array $data): ApiClient
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
     * @return ApiClient
     */
    private function setRequestHeaders(array $headers): ApiClient
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
     * @return ApiClient
     */
    private function setResponseBody($body): ApiClient
    {
        if (is_string($body)) {
            $this->responseBody = json_decode($body, true) ?? null;
        } else {
            $this->responseBody = $body;
        }
        return $this;
    }

    /**
     * Set the response headers
     * @param array $headers
     * @return ApiClient
     */
    private function setResponseHeaders(array $headers): ApiClient
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
     * @return array
     */
    public function get(array $data = []): array
    {
        return $this->fetch('GET', $data);

    }

    /**
     * Post data to endpoint
     *
     * @param array $data
     * @return array
     */
    public function post(array $data): array
    {
        return $this->fetch('POST', $data);
    }


    /**
     * Handles both GET and POST requests
     * @param string $method
     * @param array $data
     * @return array
     */
    private function fetch(string $method = 'GET', array $data = [])
    {

        $client = new GuzzleHttp\Client();
        $endpoint = $this->baseUrl . $this->getRequestUri();

        $this->setRequestHeaders([
            'Accept' => 'application/json',
            'Accept-Encoding' => 'identity'
        ]);

        $this->setRequestBody($data);

        $key = 'query';

        if ($method == 'POST') {
            $key = 'json';
        }

        try {

            $res = $client->request($method, $endpoint, [
                'headers' => $this->getRequestHeaders(),
                $key => $this->getRequestBody()
            ]);


            $this->setStatusCode($res->getStatusCode());
            $this->setResponseHeaders($res->getHeaders());
            $this->setResponseBody((string)$res->getBody());

        } catch (ClientException $e) {

            $this->setStatusCode($e->getResponse()->getStatusCode());
            $this->setResponseHeaders($e->getResponse()->getHeaders());
            $this->setResponseBody((string)$e->getResponse()->getBody());
            $this->setResponseBody(array_merge($this->getResponseBody(), ['success' => false]));

        } catch (ConnectException $e) {

            $this->setResponseBody(['success' => false]);

        } finally {

            return $this->getResponseBody();
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
            'status_code' => $this->getStatusCode(),
            'request' => [
                'body' => $this->getRequestBody(),
                'headers' => $this->getRequestHeaders()
            ],
            'response' => [
                'body' => $this->getResponseBody(),
                'headers' => $this->getResponseHeaders()
            ]
        ];
        return (object)$debug;
    }

    public function __debugInfo()
    {
        return (array) $this->debug();
    }

    /**
     * Returns the error object
     * @return array|null
     */
    public function getError(): ?array
    {
        if ($this->success === false) {
            $data = $this->getResponseBody();
            unset($data['success']);
            return $data;
        }
    }
}
