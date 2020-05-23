<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Establishment;
use App\Models\Admin\Category;
use App\Models\Admin\Rhythm;

class EstablishmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $balada = Category::where('name', 'Balada')->first();
        $bares = Category::where('name', 'Bares')->first();
        $rave = Category::where('name', 'Rave')->first();
        $tabacaria = Category::where('name', 'Tabacaria')->first();

        $eletronica = Rhythm::where('name', 'Eletrônica')->first();
        $pagode = Rhythm::where('name', 'Pagode')->first();
        $rap = Rhythm::where('name', 'Rap')->first();
        $rock = Rhythm::where('name', 'Rock')->first();
        $reggae = Rhythm::where('name', 'Reggae')->first();
        $pop = Rhythm::where('name', 'Pop')->first();
        $funk = Rhythm::where('name', 'Funk')->first();
        $axe = Rhythm::where('name', 'Axé')->first();
        $sertanejo = Rhythm::where('name', 'Sertanejo')->first();

        # TABACARIA PRIMO - ID = 1

        $establishment = new Establishment();
        $establishment->user_id = 2;
        $establishment->corporate_name = 'Tabacaria Primo';
        $establishment->state_registration = '8869182916';
        $establishment->details = 'Tabacaria primo, venha conhecer e fumar um narguile conosco.';
        $establishment->type_license = 'b';
        $establishment->status = true;
        $establishment->save();
        $establishment->establishments_category()->attach($tabacaria);
        $establishment->establishment_statistics()->create();
        $establishment->establishments_photos()->create(['img_path' => 'establishment/primos1.jpg', 'sequence' => 1]);
        $establishment->establishments_photos()->create(['img_path' => 'establishment/primos2.jpg', 'sequence' => 2]);
        $establishment->establishments_photos()->create(['img_path' => 'establishment/primos3.jpg', 'sequence' => 3]);

        # VICTORIA VILLA - ID = 2

        $establishment2 = new Establishment();
        $establishment2->user_id = 3;
        $establishment2->corporate_name = 'Victoria Villa';
        $establishment2->state_registration = '2050239090';
        $establishment2->details = 'Venha dançar aqui no Victoria Villa, temos dois palcos e diversas atrações.';
        $establishment2->type_license = 'f';
        $establishment2->status = true;
        $establishment2->save();
        $establishment2->establishments_category()->attach($balada);
        $establishment2->establishments_rhythm()->attach($sertanejo);
        $establishment2->establishments_rhythm()->attach($pagode);
        $establishment2->establishment_statistics()->create();
        $establishment2->establishments_photos()->create(['img_path' => 'establishment/victoriavilla1.jpg', 'sequence' => 1]);

        # DANGHAI - ID = 3

        $establishment3 = new Establishment();
        $establishment3->user_id = 4;
        $establishment3->corporate_name = 'Danghai Club';
        $establishment3->state_registration = '7621624584';
        $establishment3->details = 'Venha conhecer nossas musicas eletrônica, tem muita novidade e diversos artistas talentosos.';
        $establishment3->type_license = 'f';
        $establishment3->status = true;
        $establishment3->save();
        $establishment3->establishments_category()->attach($balada);
        $establishment3->establishments_rhythm()->attach($eletronica);
        $establishment3->establishment_statistics()->create();
        $establishment3->establishments_photos()->create(['img_path' => 'establishment/danghai1.jpg', 'sequence' => 1]);
        $establishment3->establishments_photos()->create(['img_path' => 'establishment/danghai2.jpg', 'sequence' => 2]);
        $establishment3->establishments_photos()->create(['img_path' => 'establishment/danghai3.png', 'sequence' => 3]);

        # PARK ART - ID = 4

        $establishment4 = new Establishment();
        $establishment4->user_id = 5;
        $establishment4->corporate_name = 'Park Art';
        $establishment4->state_registration = '5360925872';
        $establishment4->details = 'Venha conhecer nossas musicas eletrônica, tem muita novidade e diversos artistas talentosos.';
        $establishment4->type_license = 'f';
        $establishment4->status = true;
        $establishment4->save();
        $establishment4->establishments_category()->attach($rave);
        $establishment4->establishments_rhythm()->attach($eletronica);
        $establishment4->establishment_statistics()->create();
        $establishment4->establishments_photos()->create(['img_path' => 'establishment/parkart1.jpg', 'sequence' => 1]);
        $establishment4->establishments_photos()->create(['img_path' => 'establishment/parkart2.jpg', 'sequence' => 2]);
        $establishment4->establishments_photos()->create(['img_path' => 'establishment/parkart3.jpg', 'sequence' => 3]);

        # BLOOD ROCK - ID = 5

        $establishment5 = new Establishment();
        $establishment5->user_id = 6;
        $establishment5->corporate_name = 'Blood Rock';
        $establishment5->state_registration = '1393799265';
        $establishment5->details = 'Venha conhecer nossas musicas de rock, tem muita novidade e diversos artistas talentosos.';
        $establishment5->type_license = 'b';
        $establishment5->status = true;
        $establishment5->save();
        $establishment5->establishments_category()->attach($balada);
        $establishment5->establishments_rhythm()->attach($rock);
        $establishment5->establishment_statistics()->create();
        $establishment5->establishments_photos()->create(['img_path' => 'establishment/bloodbar1.jpg', 'sequence' => 1]);
        $establishment5->establishments_photos()->create(['img_path' => 'establishment/bloodbar2.jpg', 'sequence' => 2]);
        $establishment5->establishments_photos()->create(['img_path' => 'establishment/bloodbar3.jpg', 'sequence' => 3]);

        # TABACARIA MANDELA - ID = 6

        $establishment6 = new Establishment();
        $establishment6->user_id = 7;
        $establishment6->corporate_name = 'Tabacaria Mandela';
        $establishment6->state_registration = '5305526837';
        $establishment6->details = 'Tabacaria mandela, venha conhecer e fumar um narguile conosco.';
        $establishment6->type_license = 'b';
        $establishment6->status = true;
        $establishment6->save();
        $establishment6->establishments_category()->attach($tabacaria);
        $establishment->establishments_rhythm()->attach($eletronica);
        $establishment->establishments_rhythm()->attach($rap);
        $establishment->establishments_rhythm()->attach($reggae);
        $establishment->establishments_rhythm()->attach($funk);
        $establishment6->establishment_statistics()->create();
        $establishment6->establishments_photos()->create(['img_path' => 'establishment/mandela1.jpg', 'sequence' => 1]);

        # MILLENIUM DISCO CLUB - ID = 7

        $establishment7 = new Establishment();
        $establishment7->user_id = 8;
        $establishment7->corporate_name = 'Millenium Disco Club';
        $establishment7->state_registration = '1690829793';
        $establishment7->details = 'Venha conhecer nossas musicas, tem muita novidade e diversos artistas talentosos.';
        $establishment7->type_license = 'f';
        $establishment7->status = true;
        $establishment7->save();
        $establishment7->establishments_category()->attach($balada);
        $establishment7->establishments_rhythm()->attach($pop);
        $establishment7->establishments_rhythm()->attach($funk);
        $establishment7->establishments_rhythm()->attach($axe);
        $establishment7->establishments_rhythm()->attach($eletronica);
        $establishment7->establishment_statistics()->create();
        $establishment7->establishments_photos()->create(['img_path' => 'establishment/millenium1.jpg', 'sequence' => 1]);
        $establishment7->establishments_photos()->create(['img_path' => 'establishment/millenium2.jpg', 'sequence' => 2]);

        # DOISZERODOIS - ID = 8

        $establishment8 = new Establishment();
        $establishment8->user_id = 9;
        $establishment8->corporate_name = 'Doiszerodois';
        $establishment8->state_registration = '4356917494';
        $establishment8->details = 'Tabacaria doiszerodois, venha conhecer nossa casa e fumar um narguile conosco.';
        $establishment8->type_license = 'f';
        $establishment8->status = true;
        $establishment8->save();
        $establishment8->establishments_category()->attach($tabacaria);
        $establishment8->establishments_rhythm()->attach($eletronica);
        $establishment8->establishments_rhythm()->attach($rap);
        $establishment8->establishments_rhythm()->attach($reggae);
        $establishment8->establishments_rhythm()->attach($funk);
        $establishment8->establishment_statistics()->create();
        $establishment8->establishments_photos()->create(['img_path' => 'establishment/doiszerodois1.jpg', 'sequence' => 1]);
        $establishment8->establishments_photos()->create(['img_path' => 'establishment/doiszerodois2.jpg', 'sequence' => 2]);
        $establishment8->establishments_photos()->create(['img_path' => 'establishment/doiszerodois3.jpg', 'sequence' => 3]);


        # RODEO BAR - ID = 9

        $establishment9 = new Establishment();
        $establishment9->user_id = 10;
        $establishment9->corporate_name = 'Rodeo Country Bar';
        $establishment9->state_registration = '1564083794';
        $establishment9->details = 'Venha conhecer nossas musicas, tem muita novidade e diversos artistas talentosos.';
        $establishment9->type_license = 'b';
        $establishment9->status = true;
        $establishment9->save();
        $establishment9->establishments_category()->attach($tabacaria);
        $establishment9->establishments_rhythm()->attach($sertanejo);
        $establishment9->establishments_rhythm()->attach($pagode);
        $establishment9->establishments_rhythm()->attach($funk);
        $establishment9->establishment_statistics()->create();
        $establishment9->establishments_photos()->create(['img_path' => 'establishment/rodeobar1.jpg', 'sequence' => 1]);
        $establishment9->establishments_photos()->create(['img_path' => 'establishment/rodeobar2.jpg', 'sequence' => 2]);
        $establishment9->establishments_photos()->create(['img_path' => 'establishment/rodeobar3.jpg', 'sequence' => 3]);

        # Havana Bar - ID = 10

        $establishment10 = new Establishment();
        $establishment10->user_id = 11;
        $establishment10->corporate_name = 'Havana Bar';
        $establishment10->state_registration = '2423037760';
        $establishment10->details = 'Venha conhecer nosso bar e tomar uma bebida conosco.';
        $establishment10->type_license = 'b';
        $establishment10->status = true;
        $establishment10->save();
        $establishment10->establishments_category()->attach($bares);
        $establishment10->establishments_rhythm()->attach($sertanejo);
        $establishment10->establishments_rhythm()->attach($pagode);
        $establishment10->establishments_rhythm()->attach($funk);
        $establishment10->establishments_rhythm()->attach($rap);
        $establishment10->establishments_rhythm()->attach($reggae);
        $establishment10->establishment_statistics()->create();
        $establishment10->establishments_photos()->create(['img_path' => 'establishment/havana1.jpg', 'sequence' => 1]);

        # Peppers - ID = 11

        $establishment11 = new Establishment();
        $establishment11->user_id = 12;
        $establishment11->corporate_name = 'Peppers';
        $establishment11->state_registration = '1669594387';
        $establishment11->details = 'Venha conhecer nossas musicas, tem muita novidade.';
        $establishment11->type_license = 'f';
        $establishment11->status = true;
        $establishment11->save();
        $establishment11->establishments_category()->attach($balada);
        $establishment11->establishments_rhythm()->attach($pop);
        $establishment11->establishments_rhythm()->attach($rock);
        $establishment11->establishment_statistics()->create();
        $establishment11->establishments_photos()->create(['img_path' => 'establishment/peppers1.jpg', 'sequence' => 1]);
        $establishment11->establishments_photos()->create(['img_path' => 'establishment/peppers2.png', 'sequence' => 2]);
        $establishment11->establishments_photos()->create(['img_path' => 'establishment/peppers3.png', 'sequence' => 3]);

        # James Bar - ID = 12

        $establishment12 = new Establishment();
        $establishment12->user_id = 13;
        $establishment12->corporate_name = 'James Bar';
        $establishment12->state_registration = '9459792403';
        $establishment12->details = 'Venha conhecer nossas musicas, tem muita novidade.';
        $establishment12->type_license = 'f';
        $establishment12->status = true;
        $establishment12->save();
        $establishment12->establishments_category()->attach($balada);
        $establishment12->establishments_rhythm()->attach($pop);
        $establishment12->establishments_rhythm()->attach($rock);
        $establishment12->establishments_rhythm()->attach($funk);
        $establishment12->establishment_statistics()->create();
        $establishment12->establishments_photos()->create(['img_path' => 'establishment/james1.jpg', 'sequence' => 1]);
        $establishment12->establishments_photos()->create(['img_path' => 'establishment/james2.png', 'sequence' => 2]);
        $establishment12->establishments_photos()->create(['img_path' => 'establishment/james3.png', 'sequence' => 3]);

        # Shed Bar - ID = 13

        $establishment13 = new Establishment();
        $establishment13->user_id = 14;
        $establishment13->corporate_name = 'Shed Bar';
        $establishment13->state_registration = '5836824069';
        $establishment13->details = 'Venha conhecer nossas musicas, tem muita novidade.';
        $establishment13->type_license = 'f';
        $establishment13->status = true;
        $establishment13->save();
        $establishment13->establishments_category()->attach($balada);
        $establishment13->establishments_rhythm()->attach($sertanejo);
        $establishment13->establishments_rhythm()->attach($pagode);
        $establishment13->establishments_rhythm()->attach($funk);
        $establishment13->establishment_statistics()->create();
        $establishment13->establishments_photos()->create(['img_path' => 'establishment/shed1.jpg', 'sequence' => 1]);
        $establishment13->establishments_photos()->create(['img_path' => 'establishment/shed2.jpg', 'sequence' => 2]);
        $establishment13->establishments_photos()->create(['img_path' => 'establishment/shed3.jpg', 'sequence' => 3]);
        $establishment13->establishments_photos()->create(['img_path' => 'establishment/shed4.jpg', 'sequence' => 4]);
    }
}
