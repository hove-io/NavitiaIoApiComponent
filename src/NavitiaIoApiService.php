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
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $customers;

    /**
     * Constructor
     *
     * @param array $customers
     */
    public function __construct($customers)
    {
        $this->customers = $customers;
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
            $this->customers['url']
            .'/api/users?page='.$page
            .'&count='.$count
            .'&sort_by='.$sortField
            .'&sort_order='.$sortOrder
        );
        $request->setAuth($this->customers['username'], $this->customers['password']);
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
    public function findUsersBetweenDates(
        $startDate,
        $endDate,
        $page = 0,
        $count = 10,
        $sortField = 'id',
        $sortOrder = 'asc'
    ) {
        $request = $this->client->get(
            $this->customers['url']
            .'api/users?start_date='.$startDate
            .'&end_date='.$endDate
            .'&page='.$page
            .'&count='.$count
            .'&sort_by='.$sortField
            .'&sort_order='.$sortOrder
        );
        $request->setAuth($this->customers['username'], $this->customers['password']);
        $response = $request->send();

        return json_decode((string) $response->getBody(true));
    }
}
