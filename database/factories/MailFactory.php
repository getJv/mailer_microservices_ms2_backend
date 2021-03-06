<?php

namespace Database\Factories;

use App\Models\Mail;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'         => $this->faker->title,
            'body'          => $this->faker->text(200),
            'content_type'  => $this->faker->randomElement($array = array ('text/html','text/plain','text/markdown')),
            'recipients'    => $this->faker->email,
        ];
    }
}
