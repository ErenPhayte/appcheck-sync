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

class Scan extends ApiModel
{
    /**
     * Scan constructor.
     * @param Client $client
     * @param string $id
     */
    public function __construct(Client &$client, string $id = null)
    {
        parent::__construct($client);
        if ($id != null) {
            return $this->find( $id);
        }
    }

    /**
     * @inheritDoc
     */
    public function find(string $id)
    {
        $this->setId($id);
        return $this->setEndpoint('scan/' . $id)->get();
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->setEndpoint('scans')->get();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        return $this->setEndpoint('scan/new')->post($data);
    }

    /**
     * @inheritDoc
     */
    public function update(array $data): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/update')->post($data);
        return $data->success;
    }

    /**
     * About a scan
     * @return bool
     */
    public function abort(): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/abort')->get();
        return $data->success;
    }

    /**
     * @inheritDoc
     */
    public function delete(): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/delete')->get();
        return $data->success;
    }

    /**
     * Pause a scan
     * @return bool
     */
    public function pause(): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/pause')->get();
        return $data->success;

    }

    /**
     * Resume a scan
     * @return bool
     */
    public function resume(): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/resume')->get();
        return $data->success;

    }

    /**
     * Get all scan hubs
     */
    public function hubs()
    {
        return $this->setEndpoint('scan/hubs')->get();
    }

    /**
     * Return the status of a scan
     */
    public function status()
    {
        return $this->setEndpoint('scan/' . $this->getId() . '/status')->get();
    }

    /**
     * Return a scan run
     * @param string|null $id
     * @return mixed
     */
    public function run(string $id = null)
    {

        return $this->client->run($this->getId(), $id);
    }

    /**
     * Return all vulnerabilities for scan
     * @return mixed
     */
    public function vulnerability()
    {
        return $this->client->vulnerability($this->getId());

    }

    /**
     * Return all scan profiles
     *
     */
    public function profiles()
    {
        return $this->setEndpoint('scanprofiles')->get();
    }
}
