<?php
/**
 * User: erick.antunes
 * Date: 29/08/2018
 * Time: 13:19
 */

namespace Paggcerto\Auth;

use Paggcerto\Contracts\Authentication;
use Requests_Hooks;

class NoAuth implements Authentication
{

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
        // TODO: Implement register() method.
    }
}