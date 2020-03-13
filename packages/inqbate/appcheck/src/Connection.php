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


class Connection
{

    /**
     * @var string
     */
    private $endpoint = 'https://api.appcheck-ng.com/';
    /**
     * @var string
     */
    private $apikey;

    /**
     * Connection constructor.
     *
     * @param   string   $apikey
     */
    public function __construct(string $apikey)
    {
        if(empty($apikey)) {
            throw new Exceptions\AuthNotFoundException();
        }
        $this->setApiKey($apikey);
    }

    /**
     * Fetch the endpoint
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Set the endpoint
     * @param string $endpoint
     */
    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Get the API Key
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apikey;
    }

    /**
     * Set the API Key
     * @param string $apikey
     */
    public function setApiKey(string $apikey): void
    {
        $this->apikey = $apikey;
    }

}
