<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */

namespace Inqbate\Appcheck\Models;


use Inqbate\Appcheck\ApiClient;
use Inqbate\Appcheck\Client;
use Inqbate\Appcheck\Exceptions\RecordNotFoundException;

/**
 * Short description for class
 *
 * Long description for class (if any)...
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
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint(string $endpoint) {

        $this->client->setRequestUri($endpoint);
        return $this;

    }

    /**
     * @param array $parameters
     * @return ApiModel
     */
    public function get(array $parameters = []) {
        $this->payload = $this->client->get($parameters);
        return $this;
    }

    /**
     * @param array $parameters
     * @return ApiModel
     */
    public function post(array $parameters = []) {
        $this->payload = $this->client->post($parameters);
        return $this;
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return (array) $this->client->debug();
    }

}
