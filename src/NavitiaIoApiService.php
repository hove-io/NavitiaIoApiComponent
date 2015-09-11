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
     * Constructor.
     *
     * @param string $url
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

    /**
     * Get all users.
     *
     * @return \stdClass
     */
    public function getUsers()
    {
        $request = $this->client->get($this->url.'/api/users');
        $request->setAuth($this->auth['user'], $this->auth['password']);
        $response = $request->send();

        return json_decode((string) $response->getBody(true));
    }

    /**
     * Get stat by name
     *
     * @param string $name
     * @param array $parameters GET parameters
     *
     * @return \stdClass
     */
    public function getStats($name, $parameters = array())
    {
        $response = $this->client->get('api/stats/'.$name, ['query' => $parameters]);

        return json_decode((string) $response->getBody());
    }

    /**
     * Get all users.
     *
     * @return \stdClass
     */
    public function findUsersBetweenDates($startDate, $endDate)
    {
        $query = ['start_date' => $startDate, 'end_date' => $endDate];
        $request = $this->client->get('api/users', ['query' => $query]);
        $request->setAuth($this->auth['user'], $this->auth['password']);
        $response = $request->send();

        return json_decode((string) $response->getBody(true));
    }
}
