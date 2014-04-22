<?php

/**
 * DomainManagementService.php
 *
 * @category            Account
 * @package             CoreBundle
 * @subpackage          Service
 */

namespace Hostkit\CoreBundle\Services;

/**
 * Class AccountService
 * @package Hostkit\CoreBundle\Services
 */
class AccountService
{

    public function generateRandomPassword()
    {
        //Initialize the random password
        $password = '';

        //Initialize a random desired length
        $desired_length = rand(8, 14);

        for ($length = 0; $length < $desired_length; $length++) {
            //Append a random ASCII character (including symbols)
            $password .= chr(rand(32, 126));
        }

        return $password;
    }

}
