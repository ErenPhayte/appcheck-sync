<?php
/**
 * @filesource Scan.php
 * @author Foo Bar <foo.bar@email.com>
 * @version    Release:
 * Date: 2020/03/11
 * Time: 14:56
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

    public function abort(): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/abort')->get();
        return $data->success;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/delete')->get();
        return $data->success;
    }

    public function pause(): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/pause')->get();
        return $data->success;

    }

    public function resume(): bool
    {

        $data = $this->setEndpoint('scan/' . $this->getId() . '/resume')->get();
        return $data->success;

    }

    public function hubs()
    {
        return $this->setEndpoint('scan/hubs')->get();
    }

    public function status()
    {
        return $this->setEndpoint('scan/' . $this->getId() . '/status')->get();
    }

    public function run(string $id = null)
    {

        return $this->client->run($this->getId(), $id);
    }

    public function vulnerability()
    {
        return $this->client->vulnerability($this->getId());

    }

    /**
     * @inheritDoc
     */
    public function profiles()
    {
        return $this->setEndpoint('scanprofiles')->get();
    }
}
