<?php

namespace Database\Factories;

use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

class DatabaseNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatabaseNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'type' => ThreadWasUpdated::class,
            'notifiable_id' => auth()->id() ?: User::factory()->create()->id,
            'notifiable_type' => User::class,
            'data' => ['foo' => 'bar']
        ];
    }
}
