<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */
namespace Inqbate\Appcheck;

class Scan extends AppcheckAbstract
{
    use VulnerabilityTrait;

    /**
     * Performs an action on the object
     * @param string $keyword
     * @return object|null
     */
    private function performAction(string $keyword): ?object
    {

        if (!$this->id) {
            throw new Exceptions\RecordNotFoundException();
        }
        return $this->setRequestUri('scan/' . $this->id . '/' . $keyword);

    }

    /**
     * All runs of a scan
     *
     * Response JSON Object:
     *
     *      success (boolean) – operation was successful
     *      message (string) – human readable response
     *      data (objects) – list of runs (short form)
     *
     * Response JSON Array of Objects:
     *
     *      run_id (string) – id of the run
     *      started_at (int) – timestamp when the scan run was started
     *      completed_at (int) – timestamp when the scan run was completed (or null)
     *      status (string) – run status of the run
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function runs()
    {
        return $this->performAction('runs')->get();
    }

    /**
     * A job running on a scan
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
     * @param String|null $id
     * @return ScanRun
     */
    public function run(?String $id): ScanRun
    {
        $run = new ScanRun($this->connection, $id);
        if ($id != null) {
            $run->find($id);
        }
        return $run;
    }

    /**
     * Fetch details about a scan
     *
     * Response JSON Object:
     *
     *      success (boolean) – operation was successful
     *      message (string) – human readable response
     *      data (object) – scan definition details
     *          data.scan_id (string) – ID of the scan
     *          data.name (string) – name of the scan
     *          data.user_name (string) – owner of the scan
     *          data.targets (strings) – list of targets of this scan
     * @param string $id
     * @return Scan
     */
    public function find(string $id)
    {
        $scan = $this->setRequestUri('scan/' . $id)->get();
        if ($scan) {
            $this->id = $id;
        }

        return $this;
    }

    /**
     * Update a scans details
     *
     * Form Parameters:
     *
     *      name – (optional) name to identify the scan definition
     *      targets – (optional, multiple) URL, hostname, or IP address
     *      profile_id – (optional) ID of a profile to overwrite settings with
     *      scan_hub – (optional) The scan hub to run the scan from
     *
     * Response JSON Object:
     *
     *      success (boolean) – operation was successful
     *      message (string) – human readable response
     *      errors (strings) – detailed list of errors
     * @param array $data
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function update(array $data): object
    {
        return $this->performAction('update')->setRequestBody($data)->post();
    }

    /**
     * Delete a scan
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
        return $this->performAction('delete')->get();
    }

    /**
     * Abort a scan
     *
     * Response JSON Object:
     *
     *      success (boolean) – action was accepted
     *      message (string) – human readable response
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function abort()
    {
        return $this->performAction('abort')->get();
    }

    /**
     * Pause a scan
     *
     * Response JSON Object:
     *
     *      success (boolean) – action was accepted
     *      message (string) – human readable response
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function pause()
    {
        return $this->performAction('pause')->get();
    }

    /**
     * Resume a scan
     *
     * Response JSON Object:
     *
     *      success (boolean) – action was accepted
     *      message (string) – human readable response
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function resume()
    {
        return $this->performAction('resume')->get();
    }

    /**
     * Start a scan
     *
     * Response JSON Object:
     *
     *      success (boolean) – action was accepted
     *      message (string) – human readable response
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function start()
    {
        return $this->performAction('start')->get();
    }

    /**
     * Status of a scan
     *
     * Response JSON Object:
     *
     *      success (boolean) – operation was successful
     *      status (string) – run status of the last run
     *      run_id (string) – ID of the last run
     *      message (string) – human readable response
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function status()
    {
        return $this->performAction('status')->get();
    }

    /**
     * Create a new scan
     *
     * Form Parameters:
     *      name – name to identify the scan definition
     *      targets – (multiple) URL, hostname, or IP address
     *      profile_id – (optional) ID of a profile to apply
     *      scan_hub – (optional) Which scanhub or hub group to use
     *
     * Response JSON Object:
     *
     *      success (boolean) – operation was successful
     *      message (string) – human readable response
     *      errors (strings) – detailed list of errors
     *      scan_id (string) – ID of the created scan definition
     * @param array $data
     * @return Scan
     */
    public function create(array $data)
    {

        $scan = $this->setRequestUri('scan/new')->setRequestBody($data)->post();
        if ($scan) {
            $this->id = $scan->scan_id;
        }
        return $this;
    }

    /**
     * Fetch scan hubs
     * @return object|null
     */
    public function hubs()
    {
        return $this->setRequestUri('scan/hubs')->get();
    }
}
