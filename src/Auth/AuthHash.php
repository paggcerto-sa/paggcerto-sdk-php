<?php
/**
 * Created by PhpStorm.
 * User: marcus.vinicius
 * Date: 29/08/2018
 * Time: 10:43
 */

namespace Paggcerto\Auth;

use Paggcerto\Contracts\Authentication;
use Paggcerto\Exceptions\AuthException;
use Paggcerto\Paggcerto;
use Requests_Hooks;

class AuthHash implements Authentication
{
    /**
     *
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $token;

    public function __construct($hash)
    {
        if ($hash == null || gettype($hash) != "string") {
            throw new AuthException("Necessário passar um hash para se autenticar.", 400);
        }

        $this->hash = $hash;
    }

    /**
     * Register hooks as needed
     *
     * This method is called in {@see Requests::request} when the user has set
     * an instance as the 'auth' option. Use this callback to register all the
     * hooks you'll need.
     *
     * @see Requests_Hooks::register
     * @param Requests_Hooks $hooks Hook system
     */
    public function register(Requests_Hooks &$hooks)
    {
        $hooks->register('requests.before_request', [&$this, 'before_request']);
    }

    /**
     * Sets the authentication header.
     *
     * @param string $url
     * @param array $headers
     * @param array|string $data
     * @param string $type
     * @param array $options
     * @codeCoverageIgnore
     */
    public function before_request(&$url, &$headers, &$data, &$type, &$options)
    {
        $headers['Authorization'] = "Bearer {$this->token}";
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}