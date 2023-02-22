<?php

use App\Models\Address;
use App\Models\Car;
use App\Models\Owner;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Owner::factory()->count(500)->create()->each(function ($owner) {
            Address::factory()->count(rand(1, 3))->create(['owner_id' => $owner->id])->each(function ($address) use ($owner) {
                Car::factory()->count(rand(1, 3))->create(['owner_id' => $owner->id, 'address_id' => $address->id]);
            });
        });
    }
}
