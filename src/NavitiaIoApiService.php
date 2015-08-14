<?php

namespace CanalTP\NavitiaIoApiComponent;

use GuzzleHttp\Client;

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
        $this->auth = ['auth' => [$authUser, $authPassword]];
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
        $client = new Client(array(
            'base_url' => $this->url,
            'defaults' => $this->auth,
        ));

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
        $response = $this->client->get('api/users');

        return json_decode((string) $response->getBody());
    }
}
