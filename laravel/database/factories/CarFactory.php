<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicles = ["BMW M3", "AUDI S3", "AUDI SQ7", "NISSAN GT-R", "BUGATTI CHIRON", "FERRARI SF90", "SSC TUATARA"];
        $car = $vehicles[rand(0, 6)];
        $carExists = empty(Car::where(["vehicle"=>$car])->get()->toArray());
        if(!$carExists){
            $car = explode(' ', $car)[0];
            $car = $car." ".explode(' ', $vehicles[rand(0,6)])[1];
            if(!empty(Car::where(["vehicle"=>$car])->get()->toArray())){
                $car = $car.rand(101, 3000);
            }
        }
        return [
            'vehicle' => $car
        ];
    }
}
