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
     /** @test */
    public function an_email_can_be_updated()
    {
        $this->withoutExceptionHandling();
        Mail::factory()->create([
            'title' => 'My email title',
            'recipients' => 'email1@newmail.com',
            'content_type' => 'richText',
            'body'  => 'My email message'
        ]);


        $response = $this->patch('/api/mails/1', [
            'title' => 'My email title 2',
            'recipients' => 'email2@newmail.com',
            'content_type' => 'markdown',
            'body'  => 'My email message 2'
        ])->assertStatus(200);


        $mail = Mail::find(1);
        $this->assertEquals('My email title 2', $mail->title);
        $this->assertEquals('email2@newmail.com', $mail->recipients);
        $this->assertEquals('markdown', $mail->content_type);
        $this->assertEquals('My email message 2', $mail->body);

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

     /** @test */
    public function emails_can_be_retrieved()
    {

        $this->withoutExceptionHandling();
        Mail::factory()->count(3)->create();
        $mails = mail::all();

        $this->get('/api/mails/')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'mails',
                            'id'   => $mails->last()->id,
                            'attributes' => [
                                'title'        => $mails->last()->title,
                                'recipients'   => $mails->last()->recipients,
                                'content_type' => $mails->last()->content_type,
                                'body'         => $mails->last()->body,
                            ],

                        ],
                        'links' => [
                            'self' => url('/api/mails/' . $mails->last()->id)
                        ]
                    ]
                ],
                'total_mails' => $mails->count(),
                'links' => [
                    'self' => url('/api/mails/')
                ]
            ]);
    }


}
