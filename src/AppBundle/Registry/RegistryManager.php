<?php

namespace AppBundle\Registry\Registry;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

class RegistryManager
{
    private $logger;
    private $client;

    public function __construct(LoggerInterface $logger, $baseUri)
    {
        $this->logger = $logger;
        $this->client = new Client(array(
            'base_uri' => $baseUri,
            'timeout' => 3,
            'verify' => false,
        ));
        try {
            $this->client->get('/v2');
        } catch (RequestException $e) {
            $this->logger->error(sprintf("Can not connect to %s ! %s", $baseUri, $e->getMessage()));
        }
    }

    /**
     * List available repositories.
     * @return array
     */
    public function getRepositories()
    {
        $response = $this->client->get('/v2/_catalog');
        $repositories = json_decode($response->getBody(), true)['repositories'];

        $this->logger->info(sprintf(
            "GET /v2/_catalog %s %s",
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));

        return $repositories;
    }

    /**
     * Retrieve tags for an image repository.
     * @param string $repository
     * @return array
     */
    public function getTags($repository)
    {
        $response = $this->client->get('/v2/'.$repository.'/tags/list');
        $tags = json_decode($response->getBody(), true)['tags'];

        $this->logger->info(sprintf(
            "GET /v2/%s/tags/list %s %s",
            $repository,
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));

        return $tags;
    }
}
