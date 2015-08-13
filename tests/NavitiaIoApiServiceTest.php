<?php

namespace CanalTP\TyrComponent\Tests;

use CanalTP\NavitiaIoApiComponent\NavitiaIoApiService;

class NavitiaIoApiServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TyrService
     */
    private $navitiaIoService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->navitiaIoApiService = new NavitiaIoApiService('http://navitia.local/', 'user_test', 'password_test');
    }

    public function testGetUsers()
    {
        $result = $this->navitiaIoApiService->getUsers();

        $this->assertTrue(property_exists($result, 'users'));
    }
}