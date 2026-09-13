<?php

namespace App\Tests\Controller\Admin;

use App\Tests\AdminAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EducationCrudTest extends WebTestCase
{
    use AdminAuthenticationTrait;

    public function testCreateEducationEntryWithCourse(): void
    {
        $client = static::createClient();
        $this->loginAsAdmin($client);

        $crawler = $client->request('GET', '/admin/education/new');
        $form = $crawler->selectButton('Save')->form([
            'education_entry[startDate]' => '2018-09-01',
            'education_entry[endDate]' => '2021-06-01',
            'education_entry[university]' => 'Test University',
            'education_entry[qualification]' => 'BEng (Hons) Computer Science',
            'education_entry[position]' => '0',
        ]);
        $client->submit($form);

        self::assertResponseRedirects('/admin/education');
        $client->followRedirect();
        self::assertSelectorTextContains('body', 'BEng (Hons) Computer Science');

        // add a course to the created entry
        $coursesLink = $client->getCrawler()->selectLink('Courses')->link();
        $client->click($coursesLink);

        $addCourseLink = $client->getCrawler()->selectLink('Add course')->link();
        $courseCrawler = $client->click($addCourseLink);

        $courseForm = $courseCrawler->selectButton('Save')->form([
            'education_course[name]' => 'Final Year Project',
            'education_course[grade]' => 'First',
            'education_course[githubUrl]' => 'https://github.com/example/fyp',
            'education_course[position]' => '0',
        ]);
        $client->submit($courseForm);

        self::assertResponseRedirects();
        $client->followRedirect();
        self::assertSelectorTextContains('body', 'Final Year Project');

        // public experience page shows the course under education
        $client->request('GET', '/experience');
        self::assertSelectorTextContains('body', 'BEng (Hons) Computer Science');
        self::assertSelectorTextContains('body', 'Final Year Project');
    }
}
