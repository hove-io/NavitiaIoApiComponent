<?php

namespace CanalTP\NavitiaIoApiComponent\tests;

use CanalTP\NavitiaIoApiComponent\NavitiaIoApiService;

class NavitiaIoApiServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NavitiaIoApiService
     */
    private $navitiaIoApiService;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->navitiaIoApiService = new NavitiaIoApiService([
            'navio' => [
                'host' => 'navitia',
                'url' => 'http://mock.ette',
                'username' => 'user_test',
                'password' => 'password_test'
            ],
        ]);
    }

    public function testGetUsers()
    {
        $guzzleClientMock = $this->getMock('Guzzle\Http\Client', ['get']);
        $requestMock = $this->getMockForAbstractClass('Guzzle\Http\Message\RequestInterface', ['setAuth', 'send']);
        $responseMock = $this->getMock('Guzzle\Http\Message\Response', ['getBody'], [], '', false);

        $guzzleClientMock
            ->expects($this->once())
            ->method('get')
            ->with('http://mock.ette/api/users?page=2&count=16&sort_by=id&sort_order=desc')
            ->willReturn($requestMock)
        ;

        $requestMock
            ->expects($this->once())
            ->method('setAuth')
            ->with('user_test', 'password_test')
        ;

        $requestMock
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValue($responseMock))
        ;

        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue('{"users":[]}'))
        ;

        $this->navitiaIoApiService->setClient($guzzleClientMock);

        $result = $this->navitiaIoApiService->getUsers(2, 16, 'id', 'desc');

        $this->assertObjectHasAttribute('users', $result);
    }

    public function testGetUser()
    {
        $guzzleClientMock = $this->getMock('Guzzle\Http\Client', ['get']);
        $requestMock = $this->getMockForAbstractClass('Guzzle\Http\Message\RequestInterface', ['setAuth', 'send']);
        $responseMock = $this->getMock('Guzzle\Http\Message\Response', ['getBody'], [], '', false);

        $guzzleClientMock
            ->expects($this->once())
            ->method('get')
            ->with('http://mock.ette/api/users/69')
            ->willReturn($requestMock)
        ;

        $requestMock
            ->expects($this->once())
            ->method('setAuth')
            ->with('user_test', 'password_test')
        ;

        $requestMock
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValue($responseMock))
        ;

        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue('{"users":[]}'))
        ;

        $this->navitiaIoApiService->setClient($guzzleClientMock);

        $result = $this->navitiaIoApiService->getUser(69);

        $this->assertObjectHasAttribute('users', $result);
    }

    public function testFindUsersBetweenDates()
    {
        $guzzleClientMock = $this->getMock('Guzzle\Http\Client', ['get']);
        $requestMock = $this->getMockForAbstractClass('Guzzle\Http\Message\RequestInterface', ['setAuth', 'send']);
        $responseMock = $this->getMock('Guzzle\Http\Message\Response', ['getBody'], [], '', false);

        $guzzleClientMock
            ->expects($this->once())
            ->method('get')
            ->with(
                'http://mock.ette/api/users?'
                .'start_date=1991-11-09&end_date=2010-10-20'
                .'&page=2&count=16&sort_by=id&sort_order=desc'
            )
            ->willReturn($requestMock)
        ;

        $requestMock
            ->expects($this->once())
            ->method('setAuth')
            ->with('user_test', 'password_test')
        ;

        $requestMock
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValue($responseMock))
        ;

        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue('{"users":[]}'))
        ;

        $this->navitiaIoApiService->setClient($guzzleClientMock);

        $result = $this->navitiaIoApiService->findUsersBetweenDates('1991-11-09', '2010-10-20', 2, 16, 'id', 'desc');

        $this->assertObjectHasAttribute('users', $result);
    }

    public function testPatchUser()
    {
        $guzzleClientMock = $this->getMock('Guzzle\\Http\\Client', ['patch']);
        $requestMock = $this->getMock('Guzzle\\Http\\Message\\Request', ['setAuth', 'setBody', 'send'], [], '', false);
        $responseMock = $this->getMock('Guzzle\\Http\\Message\\Response', ['getBody'], [], '', false);

        // Assert expected url is called
        $guzzleClientMock
            ->expects($this->once())
            ->method('patch')
            ->with('http://mock.ette/api/users/42')
            ->willReturn($requestMock)
        ;

        // Assert authentication
        $requestMock
            ->expects($this->once())
            ->method('setAuth')
            ->with('user_test', 'password_test')
        ;

        // Assert expected request body is set
        $requestMock
            ->expects($this->once())
            ->method('setBody')
            ->with('{"firstName":"Tyler","company":"Paper Street Soap Company"}')
            ->will($this->returnValue($requestMock))
        ;

        // Assert request is sent
        $requestMock
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValue($responseMock))
        ;

        // Assert reponse body is used
        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(''))
        ;

        // Mock guzzle client
        $this->navitiaIoApiService->setClient($guzzleClientMock);

        // Call tested method
        $this->navitiaIoApiService->patchUser(42, array(
            'firstName' => 'Tyler',
            'company' => 'Paper Street Soap Company',
        ));
    }
}
