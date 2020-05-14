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
        # EVENTO PRIMO TABACARIA - ID = 1

        $address = EstablishmentAddress::where('zip_code', '83326500')->first();

        $event = new Event();

        $event->name = 'Narguile Fest';
        $event->date_event = '2020-05-30';
        $event->price = 10.00;
        $event->cover_path = 'event/primo-evento1.jpg';
        $event->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed semper nibh. Suspendisse scelerisque mauris sit amet egestas mattis. Vestibulum nec cursus augue. Proin malesuada consectetur sapien, id rutrum ante vestibulum vitae. Cras luctus tincidunt pellentesque. Nam diam velit, rutrum iaculis dignissim a, pulvinar nec velit.';
        $event->start_time = '14:00';
        $event->end_time = '18:30';
        $event->status = true;
        $event->establishment_id = $address->establishment_id;
        $event->establishment_address_id = $address->id;
        $event->save();

        # EVENTO PRIMO TABACARIA - ID = 2

        $event2 = new Event();

        $event2->name = 'Narguile Fest';
        $event2->date_event = '2020-04-30';
        $event2->price = 20.00;
        $event2->cover_path = 'event/primo-evento2.jpg';
        $event2->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed semper nibh. Suspendisse scelerisque mauris sit amet egestas mattis. Vestibulum nec cursus augue. Proin malesuada consectetur sapien, id rutrum ante vestibulum vitae. Cras luctus tincidunt pellentesque. Nam diam velit, rutrum iaculis dignissim a, pulvinar nec velit.';
        $event2->start_time = '14:00';
        $event2->end_time = '18:30';
        $event2->status = false;
        $event2->establishment_id = $address->establishment_id;
        $event2->establishment_address_id = $address->id;
        $event2->save();

        # VICTORIA VILLA - ID = 3

        $address1 = EstablishmentAddress::where('zip_code', '82810350')->first();

        $event3 = new Event();

        $event3->name = 'Social';
        $event3->date_event = '2020-05-15';
        $event3->price = 50.00;
        $event3->cover_path = 'event/victoriavilla-evento1.jpg';
        $event3->description = 'Donec eu volutpat urna, vel ornare erat. Aliquam id ligula accumsan, tincidunt nunc in, dapibus lectus. Etiam lacinia urna nec nibh commodo sodales.';
        $event3->start_time = '23:00';
        $event3->end_time = '06:00';
        $event3->status = true;
        $event3->establishment_id = $address1->establishment_id;
        $event3->establishment_address_id = $address1->id;
        $event3->save();

        # DANGHAI - ID = 4

        $address2 = EstablishmentAddress::where('zip_code', '80420000')->first();

        $event4 = new Event();

        $event4->name = 'Play in track';
        $event4->date_event = '2020-05-20';
        $event4->price = 65.00;
        $event4->cover_path = 'event/danghai-event.png';
        $event4->description = 'Sed arcu lectus, dictum luctus mattis ut, vehicula vel lectus. Phasellus ultrices dapibus quam nec imperdiet.';
        $event4->start_time = '22:00';
        $event4->end_time = '06:00';
        $event4->status = true;
        $event4->establishment_id = $address2->establishment_id;
        $event4->establishment_address_id = $address2->id;
        $event4->save();

        # PARK ART - ID = 5

        $address3 = EstablishmentAddress::where('zip_code', '83322210')->first();

        $event5 = new Event();

        $event5->name = 'TNT xmas';
        $event5->date_event = '2020-06-26';
        $event5->price = 80.00;
        $event5->cover_path = 'event/parkart-event1.jpg';
        $event5->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event5->start_time = '22:00';
        $event5->end_time = '11:00';
        $event5->status = true;
        $event5->establishment_id = $address3->establishment_id;
        $event5->establishment_address_id = $address3->id;
        $event5->save();

        # Blood Rock - ID = 6

        $address4 = EstablishmentAddress::where('building_number', '1212')->first();

        $event6 = new Event();

        $event6->name = 'Rock day';
        $event6->date_event = '2020-06-10';
        $event6->price = 50.00;
        $event6->cover_path = 'event/bloodbar-evento1.jpg';
        $event6->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event6->start_time = '22:00';
        $event6->end_time = '06:00';
        $event6->status = true;
        $event6->establishment_id = $address4->establishment_id;
        $event6->establishment_address_id = $address4->id;
        $event6->save();

        # Blood Rock - ID = 7

        $event7 = new Event();

        $event7->name = 'Festa anos 90';
        $event7->date_event = '2020-06-15';
        $event7->price = 50.00;
        $event7->cover_path = 'event/bloodbar-evento2.jpg';
        $event7->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event7->start_time = '22:00';
        $event7->end_time = '06:00';
        $event7->status = true;
        $event7->establishment_id = $address4->establishment_id;
        $event7->establishment_address_id = $address4->id;
        $event7->save();

        # Mandela - ID = 8

        $address5 = EstablishmentAddress::where('zip_code', '83325342')->first();

        $event8 = new Event();

        $event8->name = 'Arguile club Edition 7';
        $event8->date_event = '2020-05-25';
        $event8->price = 25.00;
        $event8->cover_path = 'event/mandela-evento1.jpg';
        $event8->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event8->start_time = '18:00';
        $event8->end_time = '22:00';
        $event8->status = true;
        $event8->establishment_id = $address5->establishment_id;
        $event8->establishment_address_id = $address5->id;
        $event8->save();

        # Millenium Club - ID = 9

        $address6 = EstablishmentAddress::where('building_number', '12329')->first();

        $event9 = new Event();

        $event9->name = 'Jogo Virou';
        $event9->date_event = '2020-05-27';
        $event9->price = 40.00;
        $event9->cover_path = 'event/millenium-evento1.jpg';
        $event9->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event9->start_time = '22:00';
        $event9->end_time = '06:00';
        $event9->status = true;
        $event9->establishment_id = $address6->establishment_id;
        $event9->establishment_address_id = $address6->id;
        $event9->save();

        # Millenium Club - ID = 10

        $event10 = new Event();

        $event10->name = 'Favela Venceu';
        $event10->date_event = '2020-05-27';
        $event10->price = 40.00;
        $event10->cover_path = 'event/millenium-evento2.jpg';
        $event10->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event10->start_time = '22:00';
        $event10->end_time = '06:00';
        $event10->status = true;
        $event10->establishment_id = $address6->establishment_id;
        $event10->establishment_address_id = $address6->id;
        $event10->save();

        # Doiszerodois - ID = 11

        $address7 = EstablishmentAddress::where('building_number', '12290')->first();

        $event11 = new Event();

        $event11->name = 'Stanup Fest Edition';
        $event11->date_event = '2020-07-27';
        $event11->price = 55.00;
        $event11->cover_path = 'event/doiszerodois-event1.jpg';
        $event11->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event11->start_time = '22:00';
        $event11->end_time = '06:00';
        $event11->status = true;
        $event11->establishment_id = $address7->establishment_id;
        $event11->establishment_address_id = $address7->id;
        $event11->save();

        # Rodeo Bar - ID = 12

        $address8 = EstablishmentAddress::where('zip_code', '82590300')->first();

        $event12 = new Event();

        $event12->name = 'Talles & Murilo';
        $event12->date_event = '2020-06-15';
        $event12->price = 30.00;
        $event12->cover_path = 'event/rodeobar-event1.jpg';
        $event12->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event12->start_time = '22:00';
        $event12->end_time = '06:00';
        $event12->status = true;
        $event12->establishment_id = $address8->establishment_id;
        $event12->establishment_address_id = $address8->id;
        $event12->save();

        # Peppers - ID = 13

        $address9 = EstablishmentAddress::where('building_number', '1122')->first();

        $event13 = new Event();

        $event13->name = 'Noite do Pote da Sorte';
        $event13->date_event = '2020-06-17';
        $event13->price = 100.00;
        $event13->cover_path = 'event/peppers-event1.jpg';
        $event13->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event13->start_time = '22:00';
        $event13->end_time = '06:00';
        $event13->status = true;
        $event13->establishment_id = $address9->establishment_id;
        $event13->establishment_address_id = $address9->id;
        $event13->save();

        # James Bar - ID = 14

        $address10 = EstablishmentAddress::where('zip_code', '80430180')->first();

        $event14 = new Event();

        $event14->name = 'Pancadão';
        $event14->date_event = '2020-06-21';
        $event14->price = 50.00;
        $event14->cover_path = 'event/james-evento1.jpg';
        $event14->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event14->start_time = '22:00';
        $event14->end_time = '06:00';
        $event14->status = true;
        $event14->establishment_id = $address10->establishment_id;
        $event14->establishment_address_id = $address10->id;
        $event14->save();

        # Shed Bar - ID = 15

        $address11 = EstablishmentAddress::where('zip_code', '80440080')->first();

        $event15 = new Event();

        $event15->name = 'Fluxo';
        $event15->date_event = '2020-06-21';
        $event15->price = 150.00;
        $event15->cover_path = 'event/shed-evento1.jpg';
        $event15->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event15->start_time = '22:00';
        $event15->end_time = '06:00';
        $event15->status = true;
        $event15->establishment_id = $address11->establishment_id;
        $event15->establishment_address_id = $address11->id;
        $event15->save();

        # Shed Bar - ID = 16

        $event16 = new Event();

        $event16->name = 'Sem Abuso';
        $event16->date_event = '2020-06-21';
        $event16->price = 150.00;
        $event16->cover_path = 'event/shed-evento2.jpg';
        $event16->description = 'Aliquam erat volutpat. Nunc vel nisl ut ante varius mattis. Mauris facilisis risus sed est laoreet, a placerat ipsum dapibus. Nulla luctus augue eget ligula elementum efficitur.';
        $event16->start_time = '22:00';
        $event16->end_time = '06:00';
        $event16->status = true;
        $event16->establishment_id = $address11->establishment_id;
        $event16->establishment_address_id = $address11->id;
        $event16->save();


    }
}
