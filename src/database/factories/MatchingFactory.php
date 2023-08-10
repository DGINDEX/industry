<?php

namespace Database\Factories;

use App\Matching;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatchingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Matching::class;

    private static $sequence = 1;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'company_id' => self::$sequence,
            'project_name' => $this->faker->name,
            'comment' => $this->faker->sentence,
            'project_content' => $this->faker->paragraph,
            'desired_delivery_date' => $this->faker->dateTimeThisYear,
            'status' => 1,
            'responsible_name' => $this->faker->name,
            'tel' => $this->faker->phoneNumber,
            'mail' => $this->faker->safeEmail,
            'meeting_method' => $this->faker->word,
            'disp_start_date' => $this->faker->dateTimeBetween('-2 months'),
            'disp_end_date' => $this->faker->dateTimeBetween('now', '2 months'),
        ];
    }
}
