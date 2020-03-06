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
    /**
     * @var string
     */
    private $domain;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    /**
     * Connection constructor.
     *
     * @param string $domain
     * @param string $username
     * @param string $password
     */
    public function __construct(string $domain, string $username, string$password)
    {
        if(empty($username) || empty($password) || empty($domain)) {
            throw new Exceptions\AuthNotFoundException();
        }
        $this->setDomain($domain);
        $this->setUsername($username);
        $this->setPassword($password);

    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }
}
