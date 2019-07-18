<?php
/**
 * User: sandbox-php@paggcerto.com.br
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

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $token;

    public function __construct($email = null, $password = null, $appId = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->appId = $appId;
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
     * @codeCoverageIgnore
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
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param string
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}