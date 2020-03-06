<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://unfuddle.com/stack/docs/api
 * Date: 2020/03/06
 * Time: 12:50
 */
namespace Inqbate\Unfuddle;


class Account extends UnfuddleAbstract
{
    /**
     * Update account details
     *
     *
     * @param array $data
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function update(array $data): object
    {
        return $this->setRequestUri('/account/update')->put($data);
    }

    /**
     * The activity for all Projects to which the requesting person has access
     *
     * @param array $parameters
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function activity(array $parameters): object
    {
        return $this->setRequestUri('/account/activity')->get($parameters);
    }

    /**
     * Get account activity
     *
     * @param array $data
     * @return object|null
     * @throws Exceptions\RecordNotFoundException
     */
    public function resetAccessKeys(array $data): object
    {
        return $this->setRequestUri('/account/reset_access_keys')->put($data);
    }

    /**
     * Searches through all projects to which the requester person has access for instances of the given query string.
     * Query parameters can be passed via the query string parameter or in the request body.
     *
     *
     * @param array $parameters
     * @return object|null
     */
    public function search(array $parameters): object
    {
        return $this->setRequestUri('/account/search')->get($parameters);
    }
}
