<?php

namespace CanalTP\NavitiaIoApiComponent;

use Guzzle\Http\Client;

class NavitiaIoApiService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $customer;

    /**
     * Constructor
     *
     * @param array $customers
     */
    public function __construct($customers)
    {
        $this->setClient($this->createDefaultClient());
        $this->setCustomer($customers['navio']);
    }

    /**
     * Set Customer
     *
     * @param array $customer
     *
     * @return Client
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Create a default Guzzle client.
     *
     * @return Client
     */
    private function createDefaultClient()
    {
        $client = new Client();
        $client->setSslVerification(false, false);

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

    /**
     * Get all users
     *
     * @param int $page
     * @param int $count
     * @param string $sortField
     * @param string $sortOrder
     *
     * @return mixed
     */
    public function getUsers($page = 1, $count = 10, $sortField = 'id', $sortOrder = 'asc')
    {
        $request = $this->client->get(
            $this->customer['url']
            .'/api/users?page='.$page
            .'&count='.$count
            .'&sort_by='.$sortField
            .'&sort_order='.$sortOrder
        );

        $request->setAuth($this->customer['username'], $this->customer['password']);
        $response = $request->send();

        return json_decode((string) $response->getBody(true));
    }

    /**
     * Get a specific user
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getUser($id)
    {
        $request = $this->client->get($this->customer['url'].'/api/users/'.$id);

        $request->setAuth($this->customer['username'], $this->customer['password']);
        $response = $request->send();

        return json_decode((string) $response->getBody(true));
    }

    /**
     * Edit an user fields.
     *
     * @param int $id
     * @param array $fields
     *
     * @return mixed
     */
    public function patchUser($id, array $fields)
    {
        $request = $this->client->patch($this->customer['url'].'/api/users/'.$id);

        $request->setAuth($this->customer['username'], $this->customer['password']);
        $request->setBody(json_encode($fields));

        $response = $request->send();

        return json_decode($response->getBody(true));
    }

    /**
     * Get all users
     *
     * @param string $startDate
     * @param string $endDate
     * @param int $page
     * @param int $count
     * @param string $sortField
     * @param string $sortOrder
     *
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
            $this->customer['url']
            .'/api/users?start_date='.$startDate
            .'&end_date='.$endDate
            .'&page='.$page
            .'&count='.$count
            .'&sort_by='.$sortField
            .'&sort_order='.$sortOrder
        );
        $request->setAuth($this->customer['username'], $this->customer['password']);
        $response = $request->send();

        return json_decode((string) $response->getBody(true));
    }
}
