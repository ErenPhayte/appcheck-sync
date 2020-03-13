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

namespace Inqbate\Appcheck\Models;


use Inqbate\Appcheck\Client;

/**
 *
 * @property bool $success
 */
abstract class ApiModel implements ApiModelInterface
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var array
     */
    private $payload;

    public function __construct(Client &$client)
    {
        $this->client = $client;
    }

    /**
     * Magic method to dynamically fetch data from the API response object
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (is_array($this->payload) && array_key_exists($name, $this->payload)) {
            return $this->payload[$name];
        }

        throw new \UnexpectedValueException('Undefined property $' . $name);
    }

    /**
     * Returns the primary id of the object
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets the primary id of the object
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Sets the data source to connect to
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint(string $endpoint) {

        $this->client->setRequestUri($endpoint);
        return $this;

    }

    /**
     * GET data
     * @param array $parameters
     * @return ApiModel
     */
    public function get(array $parameters = []) {
        $this->payload = $this->client->get($parameters);
        return $this;
    }

    /**
     * POST data
     * @param array $parameters
     * @return ApiModel
     */
    public function post(array $parameters = []) {
        $this->payload = $this->client->post($parameters);
        return $this;
    }

    /**
     * Return debug information about API call
     * @return array
     */
    public function __debugInfo()
    {
        return (array) $this->client->debug();
    }

}
