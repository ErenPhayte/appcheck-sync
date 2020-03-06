<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */
namespace Inqbate\Appcheck;


class ScanRun extends AppcheckAbstract
{
    use VulnerabilityTrait;

    /**
     * @var string
     */
    private $scanId;

    /**
     * @param $connection
     */
    public function __construct($connection, string $scanId)
    {
        parent::__construct($connection);
        $this->scanId = $scanId;
    }

    /**
     * Fetch details about a scan run
     *
     * Response JSON Object:
     *
     *      success (boolean) – operation was successful
     *      message (string) – human readable response
     *      data (object) – details of the run
     *          data.run_id (string) – id of the run
     *          data.is_completed (boolean) – scan run has finished
     *          data.is_aborted (boolean) – scan was aborted
     *          data.started_at (int) – timestamp when the scan run was started
     *          data.updated_at (int) – timestamp when the scan run was last updated
     *          data.completed_at (int) – timestamp when the scan run was completed (or null)
     *          data.vuln_counts (object) – the number of vulnerabilities found grouped by severity
     *      status (string) – run status of the specified run
     * @param string $id
     * @return ScanRun
     */
    public function find(string $id)
    {
        $run = $this->setRequestUri('scan/' . $this->scanId .'/run/' . $id)->get();
        if ($run) {
            $this->id = $id;
        }

        return $this;
    }

    /**
     * Delete a scan run
     *
     * Response JSON Object:
     *
     *      success (boolean) – action was accepted
     *      message (string) – human readable response
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function delete()
    {
        if (!$this->id) {
            throw new Exceptions\RecordNotFoundException();
        }
        return $this->setRequestUri('scan/' . $this->id . '/delete')->get();
    }


}
