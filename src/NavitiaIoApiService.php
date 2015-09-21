<?php

namespace CanalTP\NavitiaIoApiComponent;

use Guzzle\Http\Client;

class NavitiaIoApiService
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $auth;

    /**
     * @var Client
     */
    private $client;

    /**
     * Constructor
     *
     * @param string $url
     * @param string $authUser
     * @param string $authPassword
     */
    public function __construct($url, $authUser, $authPassword)
    {
        $this->url = $url;
        $this->auth = ['user' => $authUser, 'password' => $authPassword];
        $this->authPassword = $authPassword;

        $this->setClient($this->createDefaultClient());
    }

    /**
     * Create a default Guzzle client.
     *
     * @return Client
     */
    private function createDefaultClient()
    {
        $client = new Client();

        return $client;
    }

    /**
     * Set Guzzle client.
     *
     * @param Client $client
     *
     * @return NavitiaIoApiService
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get all users
     *
     * @param int $page
     * @param int $count
     * @param string $sortField
     * @param string $sortOrder
     * @return mixed
     */
    public function getUsers($page = 0, $count = 10, $sortField = 'id', $sortOrder = 'asc')
    {
        $request = $this->client->get(
            $this->url
            .'/api/users?page='.$page
            .'&count='.$count
            .'&sort_by='.$sortField
            .'&sort_order='.$sortOrder
        );
        $request->setAuth($this->auth['user'], $this->auth['password']);
        $response = $request->send();

        return json_decode((string) $response->getBody(true));
    }

    /**
     * Get all users
     *
     * @param $startDate
     * @param $endDate
     * @param int $page
     * @param int $count
     * @param string $sortField
     * @param string $sortOrder
     * @return mixed
     */
    public function findUsersBetweenDates($startDate, $endDate, $page = 0, $count = 10, $sortField = 'id', $sortOrder = 'asc')
    {
        $request = $this->client->get(
            $this->url
            .'api/users?start_date='.$startDate
            .'&end_date='.$endDate
            .'&page='.$page
            .'&count='.$count
            .'&sort_by='.$sortField
            .'&sort_order='.$sortOrder
        );
        $request->setAuth($this->auth['user'], $this->auth['password']);
        $response = $request->send();

        return json_decode((string) $response->getBody(true));
    }
}
