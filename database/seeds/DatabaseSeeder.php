<?php

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
        $this->call(StatesTableSeeder::class);
        $this->call(CitysTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(RhythmTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(EstablishmentTableSeeder::class);
        $this->call(EstablishmentAddressTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(UserRatingTableSeeder::class);
        $this->call(UserCommentTableSeeder::class);
    }
}
