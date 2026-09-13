<?php

namespace App\Tests\Controller\Admin;

use App\Tests\AdminAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminAccessTest extends WebTestCase
{
    use AdminAuthenticationTrait;

    public function testAdminRedirectsToLoginWhenAnonymous(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');

        self::assertResponseRedirects('/login');
    }

    public function testAdminIsReachableWhenLoggedIn(): void
    {
        $client = static::createClient();
        $this->loginAsAdmin($client);

        $client->request('GET', '/admin');

        self::assertResponseIsSuccessful();
    }
}
