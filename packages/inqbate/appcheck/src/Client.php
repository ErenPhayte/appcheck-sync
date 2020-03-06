<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */
namespace Inqbate\Appcheck;


class Client extends AppcheckAbstract
{
    use VulnerabilityTrait;

    /**
     * Return all scans
     *
     * Response JSON Object:
     *
     *       success (boolean) – operation was successful
     *       message (string) – human readable response
     *       data (objects) – list of scans
     *
     * Response JSON Array of Objects:
     *
     *       scan_id (string) – ID of the scan
     *       name (string) – name of the scan
     *       user_name (string) – name of the owner of the scan
     *       targets (strings) – targets of the scan (URLs, host names, or IP addresses)
     * @return object|null
     */
    public function scans():?object
    {
        return $this->setRequestUri('scans')->get();
    }

    /**
     *  Return all scan profiles
     *
     * Response JSON Object:
     *
     *      success (boolean) – operation was successful
     *      message (string) – human readable response
     *      data (objects) – list of scan profiles
     *
     * Response JSON Array of Objects:
     *
     *      profile_id (string) – ID of the profile
     *      name (string) – name of the profile
     *      user_name (string) – name of the owner of the profile
     * @return object|null
     */
    public function scanprofiles():?object
    {
       return $this->setRequestUri('scanprofiles')->get();

    }

    /**
     * Fetch information about a scan or create a scan
     * @param string|null $id
     * @return Scan
     */
    public function scan(?string $id = null): Scan
    {
        $scan =  new Scan($this->connection);

        if($id != null) {
            return $scan->find($id);
        }
        return $scan;
    }
}
