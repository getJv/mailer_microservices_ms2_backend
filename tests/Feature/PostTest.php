<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_create_a_post()
    {
        $this->withoutExceptionHandling();

        //$this->actingAs($user = factory(User::class)->create(), 'api');
        $response = $this->post('/api/posts', [
            'title' => 'My post title',
            'body'  => 'My body post'
        ])->assertStatus(201);

        $this->assertCount(1, Post::all());
        $post = Post::find(1);
        $this->assertEquals('My post title', $post->title);
        $this->assertEquals('My body post', $post->body);
        $response->assertJson([
            'data' => [
                'type' => 'posts',
                'id' => $post->id,
                'attributes' => [
                    'title' => $post->title,
                    'body' => $post->body,
                ],

            ],
            'links' => [
                'self' => url('/api/posts/' . $post->id)
            ]
        ]);
    }
    /** @test */
    public function post_title_is_required()
    {

        //$this->actingAs($user = factory(User::class)->create(), 'api');
        $response = $this->post('/api/posts', [
            'title' => '',
            'body'  => ''
        ])->assertStatus(422);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('title', $responseString['errors']['meta']);
        $this->assertCount(0, Post::all());
    }
    /** @test */
    public function posts_can_be_retrieved()
    {


        $this->withoutExceptionHandling();
        Post::factory()->count(3)->create();
        $posts = Post::all();

        $this->get('/api/posts/')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'id' => $posts->first()->id,
                            'attributes' => [
                                'title' => $posts->first()->title,
                                'body'  => $posts->first()->body,
                            ],

                        ],
                        'links' => [
                            'self' => url('/api/posts/' . $posts->first()->id)
                        ]
                    ]
                ],
                'total_posts' => $posts->count(),
                'links' => [
                    'self' => url('/api/posts/')
                ]
            ]);
    }
    /** @test */
    public function a_post_can_be_retrieved()
    {


        $this->withoutExceptionHandling();
        Post::factory()->count(3)->create();
        $posts = Post::all();

        $this->get('/api/posts/3')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'id' => $posts->last()->id,
                    'attributes' => [
                        'title' => $posts->last()->title,
                        'body'  => $posts->last()->body,
                    ],

                ],
                'links' => [
                    'self' => url('/api/posts/' . $posts->last()->id)
                ]
            ]);
    }

    /** @test */
    public function a_post_can_be_updated()
    {
        $this->withoutExceptionHandling();
        Post::factory()->create([
            'title' => 'Original title',
            'body' =>  'Original body',
        ]);


        $response = $this->patch('/api/posts/1', [
            'body' => 'new content',
        ])->assertStatus(200);


        $post = Post::find(1);
        $this->assertEquals('Original title', $post->title);
        $this->assertEquals('new content', $post->body);

        $response->assertJson([
            'data' => [
                'type' => 'posts',
                'id' => $post->id,
                'attributes' => [
                    'title' => $post->title,
                    'body' => $post->body,
                ],

            ],
            'links' => [
                'self' => url('/api/posts/' . $post->id)
            ]
        ]);
    }
}
