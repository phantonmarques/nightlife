<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Rhythm;
 

class RhythmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $rhythm = new Rhythm();
        $rhythm->name = 'Sertanejo';
        $rhythm->save();
        $rhythm->rhythm_statistics()->create();

        #
        
        $rhythm1 = new Rhythm();
        $rhythm1->name = 'Funk';
        $rhythm1->save();
        $rhythm1->rhythm_statistics()->create();

        #
        
        $rhythm2 = new Rhythm();
        $rhythm2->name = 'Rap';
        $rhythm2->save();
        $rhythm2->rhythm_statistics()->create();

        #
        
        $rhythm3 = new Rhythm();
        $rhythm3->name = 'Pagode';
        $rhythm3->save();
        $rhythm3->rhythm_statistics()->create();

        #

        $rhythm4 = new Rhythm();
        $rhythm4->name = 'Pop';
        $rhythm4->save();
        $rhythm4->rhythm_statistics()->create();

        #

        $rhythm5 = new Rhythm();
        $rhythm5->name = 'Rock';
        $rhythm5->save();
        $rhythm5->rhythm_statistics()->create();

    }
}
