<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Mail;

class MailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_send_an_email()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/mails', [
            'title' => 'My email title',
            'recipients' => 'email1@newmail.com',
            'content_type' => 'richText',
            'body'  => 'My email message'
        ])->assertStatus(201);

        $this->assertCount(1, Mail::all());
        $mail = Mail::find(1);
        $this->assertEquals('My email title', $mail->title);
        $this->assertEquals('email1@newmail.com', $mail->recipients);
        $this->assertEquals('richText', $mail->content_type);
        $this->assertEquals('My email message', $mail->body);
        $response->assertJson([
            'data' => [
                'type' => 'mails',
                'id' => $mail->id,
                'attributes' => [
                    'title' => $mail->title,
                    'recipients' => $mail->recipients,
                    'content_type' => $mail->content_type,
                    'body' => $mail->body,
                ],

            ],
            'links' => [
                'self' => url('/api/mails/' . $mail->id)
            ]
        ]);
    }
}
