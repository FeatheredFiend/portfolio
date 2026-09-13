<?php

namespace App\Tests\Controller\Admin;

use App\Tests\AdminAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmploymentCrudTest extends WebTestCase
{
    use AdminAuthenticationTrait;

    public function testCreateEditAndDeleteEmploymentEntry(): void
    {
        $client = static::createClient();
        $this->loginAsAdmin($client);

        $crawler = $client->request('GET', '/admin/employment/new');
        self::assertResponseIsSuccessful();

        $form = $crawler->selectButton('Save')->form([
            'employment_entry[startDate]' => '2020-01-01',
            'employment_entry[companyName]' => 'Acme Corp',
            'employment_entry[companyTitle]' => 'Senior Developer',
            'employment_entry[description]' => 'Built things.',
            'employment_entry[position]' => '0',
        ]);
        $client->submit($form);

        self::assertResponseRedirects('/admin/employment');
        $client->followRedirect();
        self::assertSelectorTextContains('body', 'Senior Developer at Acme Corp');

        // edit
        $editLink = $client->getCrawler()->selectLink('Edit')->link();
        $editCrawler = $client->click($editLink);
        $editForm = $editCrawler->selectButton('Save')->form([
            'employment_entry[companyTitle]' => 'Lead Developer',
        ]);
        $client->submit($editForm);
        self::assertResponseRedirects('/admin/employment');
        $client->followRedirect();
        self::assertSelectorTextContains('body', 'Lead Developer at Acme Corp');

        // public experience page reflects it
        $client->request('GET', '/experience');
        self::assertSelectorTextContains('body', 'Lead Developer at Acme Corp');

        // delete
        $client->request('GET', '/admin/employment');
        $deleteForm = $client->getCrawler()->filter('form')->last()->form();
        $client->submit($deleteForm);
        self::assertResponseRedirects('/admin/employment');
        $client->followRedirect();
        self::assertSelectorTextNotContains('body', 'Lead Developer at Acme Corp');
    }
}
