<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */
namespace Inqbate\Appcheck;


class Connection
{

    private $endpoint = 'https://api.appcheck-ng.com/';
    /**
     * @var string
     */
    private $apikey;

    /**
     * Connection constructor.
     *
     * @param   String   $apikey
     */
    public function __construct($apikey)
    {
        if(empty($apikey)) {
            throw new Exceptions\AuthNotFoundException();
        }
        $this->apikey = $apikey;
    }

    /**
     * @param $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param $apikey
     */
    public function setApiKey($apikey)
    {
        $this->apikey = $apikey;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apikey;
    }
}
