<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://api.appcheck-ng.com/
 * Date: 2020/03/05
 * Time: 10:00
 */
namespace Inqbate\Appcheck\Models;

interface ApiModelInterface
{
    /**
     * Fetch a single record
     * @param string $id
     */
    public function find(string $id);
    /**
     * Fetch all records
     * @param string $id
     */
    public function all();

    /**
     * create a record
     * @param array $data
     */
    public function create(array $data);

    /**
     * update a record
     * @param array $data
     */
    public function update(array $data):bool;
    /**
     * delete a record
     */
    public function delete():bool;

    /**
     * function to determine what is required for an API call.
     */
    //public function required():bool;
}
