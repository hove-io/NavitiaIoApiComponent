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
                'host' => 'http://mock.ette',
                'username' => 'user_test',
                'password' => 'password_test',
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
}
