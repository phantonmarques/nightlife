<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\EstablishmentAddress;
use App\Models\Admin\Event;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = EstablishmentAddress::where('zip_code', '83326150')->first();

        $event = new Event();

        $event->name = 'Festeja';
        $event->date_event = '2020-04-30';
        $event->price = 50.10;
        $event->cover_path = 'event/t7KUqzooGq26CeAvc0ZBdHvEU869zDeulUoJdnh1.jpeg';
        $event->description = '<b>Evento de qualidade com vários artistas top</b>';
        $event->start_time = '23:00';
        $event->end_time = '11:30';
        $event->status = true;
        $event->establishment_id = $address->establishment_id;
        $event->establishment_address_id = $address->id;
        $event->save();

        $event = new Event();

        $event->name = 'MarombaFest';
        $event->date_event = '2020-04-30';
        $event->price = 5521.10;
        $event->cover_path = 'event/kVrhmPE4LYmhozSF68gGoxq0xvI0qGGEtzR0Dlwa.png';
        $event->description = '<b>Evento de qualidade com vários artistas marombas, vamo ficar grande caraiooooo</b>';
        $event->start_time = '20:00';
        $event->end_time = '22:30';
        $event->status = true;
        $event->establishment_id = $address->establishment_id;
        $event->establishment_address_id = $address->id;
        $event->save();
    }
}
