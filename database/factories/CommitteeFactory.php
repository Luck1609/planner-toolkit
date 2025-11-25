<?php

namespace Database\Factories;

use App\Enums\MeetingTypeEnum;
use App\Models\Committee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Committee>
 */
class CommitteeFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'title' => fake()->title(),
      'firstname' => fake()->firstName(),
      'lastname' => fake()->lastName(),
      'email' => fake()->email(),
      'contact' => fake()->phoneNumber(),
      'designation' => fake()->jobTitle(),
      'panel' => Arr::random([MeetingTypeEnum::SPC, MeetingTypeEnum::TSC]),
      'role' => Arr::random(['Chairman', 'Member', 'Secretary', 'Adhoc member']),
      'status' => Arr::random(['active', 'inactive']),
    ];
  }

  protected $model = Committee::class;
}
