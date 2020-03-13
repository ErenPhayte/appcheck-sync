<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */

namespace Inqbate\Appcheck;


use Inqbate\Appcheck\Exceptions\ApiModelNotFoundException;

class Client
{
    /**
     * @var ApiClient
     */
    private $api;

    public function __construct(Connection $connection)
    {
        $this->api = new ApiClient ($connection);
    }

    public function getResponseBody()
    {
        return $this->api->getResponseBody();
    }

    public function setRequestUri(string $uri)
    {
        $this->api->setRequestUri($uri);
    }

    public function get(array $parameters = [])
    {
        return $this->api->get($parameters);
    }

    public function post(array $parameters = [])
    {

        return $this->api->post($parameters);
    }

    public function __call(string $name, array $arguments = [])
    {
        $model = __NAMESPACE__ . '\\Models\\' . ucfirst($name);

        if (class_exists($model)) {

            return new $model($this, ...$arguments);

        } else {

            throw new ApiModelNotFoundException($name . ' endpoint not found.');

        }
    }

    public function __debugInfo()
    {
        return $this->api->debug();
    }
}
