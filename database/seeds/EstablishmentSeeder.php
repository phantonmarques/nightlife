<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Establishment;
use App\Models\Admin\Category;
use App\Models\Admin\Rhythm;

class EstablishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::where('name','Bares')->first();
        $rhythm1 = Rhythm::where('name','Sertanejo')->first();
        $rhythm2 = Rhythm::where('name','Funk')->first();
        $rhythm3 = Rhythm::where('name','Rock')->first();

        $establishment = new Establishment();
        $establishment->user_id = 2;
        $establishment->corporate_name = 'AUTHENTIC OUTLET';
        $establishment->state_registration = '1234567890000000';
        $establishment->type_license = 'f';
        $establishment->status = true;
        $establishment->save();
        $establishment->establishments_category()->attach($category);
        $establishment->establishments_rhythm()->attach($rhythm1);
        $establishment->establishments_rhythm()->attach($rhythm2);
        $establishment->establishments_rhythm()->attach($rhythm3);
        $establishment->establishment_statistics()->create(['establishment_id' => $establishment->id]);

    }
}
