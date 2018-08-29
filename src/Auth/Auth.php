<?php
/**
 * User: Erick Antunes
 * Date: 24/07/2018
 * Time: 11:39
 */

namespace Paggcerto\Auth;

use Paggcerto\Contracts\Authentication;
use Requests_Hooks;

class Auth implements Authentication
{

    /**
     * Token.
     *
     * @var string
     */
    private $email;
    private $password;
    private $token;

    public function __construct($email = null, $password = null)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Register hooks as needed.
     *
     * This method is called in {@see Requests::request} when the user has set
     * an instance as the 'auth' option. Use this callback to register all the
     * hooks you'll need.
     *
     * @see \Requests_Hooks::register
     *
     * @param \Requests_Hooks $hooks Hook system
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
     */
    public function before_request(&$url, &$headers, &$data, &$type, &$options)
    {
        $headers['Authorization'] = "Bearer {$this->token}";
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}