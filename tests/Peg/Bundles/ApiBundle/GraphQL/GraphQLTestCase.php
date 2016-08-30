<?php

namespace tests\Peg\Bundles\ApiBundle\GraphQL;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class GraphQLTestCase extends WebTestCase
{
    const GRAPHQL_ENDPOINT = '/graphql/';

    protected function assertQuery($query, $jsonExpected, $jsonVariables = [])
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            self::GRAPHQL_ENDPOINT,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode(['query' => $query, 'variables' => $jsonVariables])
        );

        $result = $client->getResponse()->getContent();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $result);
        $this->assertEquals(json_decode($jsonExpected, true), json_decode($result, true), $result);
    }

    protected function runQueryFile($queryFile, $jsonFile, $variables = [])
    {
        if (!is_file($queryFile)) {
            throw new \InvalidArgumentException("Didn't find the query file '$queryFile'.");
        }

        if (!is_file($jsonFile)) {
            throw new \InvalidArgumentException("Found a query file '$queryFile' but no matching json '$jsonFile'.");
        }

        $query = file_get_contents($queryFile);
        $expected = file_get_contents($jsonFile);

        $this->assertQuery($query, $expected, $variables);
    }
}
