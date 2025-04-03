<?php

namespace App\Tests\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EventControllerTest extends WebTestCase
{
    public function testCreateEvent(): void
    {
        $formData = [
        'title' => "Test évènement",
        'date' => (new DateTime())->format('Y-m-d')
        ];
        $client = static::createClient();
        $crawler = $client->request('GET', '/evenement');
        $crawler = $client->clickLink('Ajouter un événement');
        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('app_evenement_create');
        $this->assertSelectorTextContains('h2', 'Ajouter un évènement');

        $submitButton = $crawler->selectButton('evenement_submit');
        $form = $submitButton->form();
        $form['evenement[title]'] = $formData['title'];
        $form['evenement[date]'] = $formData['date'];
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('title', $formData['title']);
    }
}