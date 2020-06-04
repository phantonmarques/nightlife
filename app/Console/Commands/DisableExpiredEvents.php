<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Event;

class DisableExpiredEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DisableExpiredEvents:verifyEvents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Desabilita eventos expirados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $eventsDisable = Event::whereStatus(1)->where('date_event', '<', date('Y-m-d'))->get();

        foreach ($eventsDisable as $eventDisable):
            $eventDisable->status = 0;
            if ($eventDisable->save())
                echo "Evento desabilitado {$eventDisable->name} - Estabelecimento [{$eventDisable->establishment->corporate_name}] \n";
            else
                echo "Erro ao desabilitar evento {$eventDisable->name} - Estabelecimento [{$eventDisable->establishment->corporate_name}] \n";

        endforeach;
    }
}
