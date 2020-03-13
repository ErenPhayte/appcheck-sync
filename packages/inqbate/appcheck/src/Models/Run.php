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
use Inqbate\Appcheck\Exceptions\ApiModelNotFoundException;

class Run extends ApiModel
{
    /**
     * @var string
     */
    private $scanId;

    /**
     * Get scan id
     * @return string
     */
    public function getScanId(): string
    {
        return $this->scanId;
    }

    /**
     * Set scan id
     * @param string $scanId
     */
    public function setScanId(string $scanId): void
    {
        $this->scanId = $scanId;
    }

    /**
     * Run constructor.
     * @param Client $client
     * @param string $scanId
     * @param string $id
     */
    public function __construct(Client &$client, string $scanId, string $id = null)
    {
        parent::__construct($client);
        $this->setScanId($scanId);
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
        return $this->setEndpoint('scan/' . $this->getScanId() . '/run/' . $id)->get();
    }

    /**
     * @inheritDoc
     */
    public function all(array $parameters = [])
    {
        return $this->setEndpoint('scan/' . $this->getScanId() . '/runs')->get($parameters);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        throw new ApiModelNotFoundException('End point doesnt exist');
    }

    /**
     * @inheritDoc
     */
    public function update(array $data): bool
    {
        throw new ApiModelNotFoundException('End point doesnt exist');
    }

    /**
     * Return all vulnerabilities for scan
     * @return mixed
     */
    public function vulnerability()
    {
        return $this->client->vulnerability($this->getScanId(), $this->getId());

    }

    /**
     * @inheritDoc
     */
    public function delete(): bool
    {
        $data =  $this->setEndpoint('scan/' . $this->getScanId() . '/run/' . $this->getId() . '/delete')->get();
        return $data->success;
    }
}
