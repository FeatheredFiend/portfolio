<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testValidSubmissionIsAccepted(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/contact',
            server: ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            content: json_encode([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'message' => 'Hello, this is a test.',
            ]),
        );

        self::assertResponseIsSuccessful();
        self::assertJsonStringEqualsJsonString('{"status":"sent"}', $client->getResponse()->getContent());
    }

    public function testInvalidSubmissionIsRejected(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/contact',
            server: ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            content: json_encode([
                'name' => '',
                'email' => 'not-an-email',
                'message' => '',
            ]),
        );

        self::assertResponseStatusCodeSame(422);
    }
}
