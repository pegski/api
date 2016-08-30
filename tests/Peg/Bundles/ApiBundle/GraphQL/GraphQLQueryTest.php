<?php

namespace tests\Peg\Bundles\ApiBundle\GraphQL;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GraphQLQueryTest extends GraphQLTestCase
{
    const QUERY_DIR = __DIR__ . '/Query';

    public function testGraphQLEndpointIsAvailable()
    {
        $client = static::createClient();

        $client->request(
            Request::METHOD_POST,
            self::GRAPHQL_ENDPOINT,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ],
            json_encode([])
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testPeg()
    {
        $this->runQueryFile(
            self::QUERY_DIR . '/Peg.graphql',
            self::QUERY_DIR . '/Peg.json',
            ['pegShortcode' => 'ab5e8cfe']
        );
    }

    public function testPegEvent()
    {
        $this->runQueryFile(
            self::QUERY_DIR . '/PegEvent.graphql',
            self::QUERY_DIR . '/PegEvent.json',
            ['pegShortcode' => 'ab5e8cfe']
        );
    }

    public function testGetAllPegs()
    {
        $this->runQueryFile(self::QUERY_DIR . '/GetAllPegs.graphql', self::QUERY_DIR . '/GetAllPegs.json');
    }
}
