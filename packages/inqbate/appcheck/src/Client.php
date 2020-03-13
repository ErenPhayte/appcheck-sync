<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * @package    Inqbate\Appcheck
 * @copyright  2020 InQBate part of Quint Group
 * Date: 2020/03/05
 * Time: 10:00
 */

namespace Inqbate\Appcheck;


use Inqbate\Appcheck\Exceptions\ApiModelNotFoundException;
use Inqbate\Appcheck\Models\ApiModel;

class Client
{
    /**
     * @var ApiClient
     */
    private $api;

    /**
     * Client constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->api = new ApiClient ($connection);
    }

    /**
     * Get the response from the API
     * @return array|null
     */
    public function getResponseBody()
    {
        return $this->api->getResponseBody();
    }

    /**
     * Set the API request URI
     * @param string $uri
     */
    public function setRequestUri(string $uri)
    {
        $this->api->setRequestUri($uri);
    }

    /**
     * Get the API request URI
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = []): array
    {
        return $this->api->get($parameters);
    }

    /**
     * Post to the API
     * @param array $parameters
     * @return array
     */
    public function post(array $parameters = []): array
    {

        return $this->api->post($parameters);
    }

    /**
     * Dynamically finds the API Model and returns the object
     * @param string $name
     * @param array $arguments
     * @return ApiModel|null
     * @throws ApiModelNotFoundException
     */
    public function __call(string $name, array $arguments = [])
    {
        $model = __NAMESPACE__ . '\\Models\\' . ucfirst($name);

        if (class_exists($model)) {

            return new $model($this, ...$arguments);

        } else {

            throw new ApiModelNotFoundException($name . ' endpoint not found.');

        }
    }

    /**
     * Outputs the debug information from API Client
     * @return object
     */
    public function __debugInfo()
    {
        return $this->api->debug();
    }
}
