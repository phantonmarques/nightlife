<?php

namespace App\Console\Commands;

use App\Mail\Email;
use App\Models\Admin\Establishment;
use App\Models\Admin\Event;
use App\Models\Site\UserLiked;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMailUserLiked extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendMailUserLiked:verifyUsersLiked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mail para usuários que seguiram eventos ou estabelecimentos';

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
        $usersLiked = UserLiked::get();

        if (count($usersLiked) > 0):
            foreach ($usersLiked as $userLiked):
                if (!empty($userLiked->establishment_id)):
                    $event = $userLiked->establishment->events()->where('date_event', date('Y-m-d',strtotime('+7 days')))
                        ->orWhere('date_event', date('Y-m-d',strtotime('+1 day')))->first();

                    if (!empty($event)):
                        if ($event->date_event === date('Y-m-d', strtotime('+7 days'))):
                            $email = 'revolt_car@hotmail.com'; // $userLiked->user->email;
                            $object = new \stdClass();
                            $object->name = $userLiked->user->name;
                            $object->event = $event->name;
                            $object->date = $event->date_event;
                            $object->type = ' do Estabelecimento ' . $userLiked->establishment->corporate_name . ' que seguiu, ';
                            $object->day = 'faltam apenas 7 dias';
                            $object->cover_path = 'https://webtec.net.br/sites-prontos/baladas-5-2/wp-content/uploads/2014/03/38balada01.jpg'; // $userLiked->event->cover_path;
                            $mail = new \stdClass();
                            $mail->subject = 'Nightlife - Lembrete do evento ' . $event->name;
                            $mail->template = 'admin.mail.event-mail';
                            $mail->replyTo = 'da3780024@gmail.com';//'fabianocm1995@hotmail.com';
                            $mail->object = $object;

                            Mail::to($email)->send(new Email($mail));

                        elseif ($event->date_event === date('Y-m-d', strtotime('+1 day'))):
                            $email = 'revolt_car@hotmail.com'; // $userLiked->user->email;
                            $object = new \stdClass();
                            $object->name = $userLiked->user->name;
                            $object->event = $event->name;
                            $object->date = $event->date_event;
                            $object->type = ' do Estabelecimento ' . $userLiked->establishment->corporate_name . ' que seguiu, ';
                            $object->day = 'falta apenas 1 dia';
                            $object->cover_path = 'https://webtec.net.br/sites-prontos/baladas-5-2/wp-content/uploads/2014/03/38balada01.jpg'; // $userLiked->event->cover_path;
                            $mail = new \stdClass();
                            $mail->subject = 'Nightlife - Lembrete do evento ' . $event->name;
                            $mail->template = 'admin.mail.event-mail';
                            $mail->replyTo = 'da3780024@gmail.com';//'fabianocm1995@hotmail.com';
                            $mail->object = $object;

                            Mail::to($email)->send(new Email($mail));

                        endif;

                    endif;
                elseif (!empty($userLiked->event_id)):
                    if ($userLiked->event->date_event === date('Y-m-d',strtotime('+7 days'))):
                        $email = 'revolt_car@hotmail.com'; // $userLiked->user->email;
                        $object = new \stdClass();
                        $object->name = $userLiked->user->name;
                        $object->event = $userLiked->event->name;
                        $object->date = $userLiked->event->date_event;
                        $object->type = ' que curtiu,';
                        $object->day = 'faltam apenas 7 dias';
                        $object->cover_path = 'https://webtec.net.br/sites-prontos/baladas-5-2/wp-content/uploads/2014/03/38balada01.jpg'; // $userLiked->event->cover_path;
                        $mail = new \stdClass();
                        $mail->subject = 'Nightlife - Lembrete do evento ' . $userLiked->event->name;
                        $mail->template = 'admin.mail.event-mail';
                        $mail->replyTo = 'da3780024@gmail.com';//'fabianocm1995@hotmail.com';
                        $mail->object = $object;

                        Mail::to($email)->send(new Email($mail));

                    elseif ($userLiked->event->date_event === date('Y-m-d', strtotime('+1 day'))):
                        $email = 'revolt_car@hotmail.com'; // $userLiked->user->email;
                        $object = new \stdClass();
                        $object->name = $userLiked->user->name;
                        $object->event = $userLiked->event->name;
                        $object->date = $userLiked->event->date_event;
                        $object->type = ' que curtiu,';
                        $object->day = 'falta apenas 1 dia';
                        $object->cover_path = 'https://webtec.net.br/sites-prontos/baladas-5-2/wp-content/uploads/2014/03/38balada01.jpg'; // $userLiked->event->cover_path;
                        $mail = new \stdClass();
                        $mail->subject = 'Nightlife - Lembrete do evento ' . $userLiked->event->name;
                        $mail->template = 'admin.mail.event-mail';
                        $mail->replyTo = 'da3780024@gmail.com';//'fabianocm1995@hotmail.com';
                        $mail->object = $object;

                        Mail::to($email)->send(new Email($mail));

                        $userLiked->delete();
                    endif;
                endif;
            endforeach;
        endif;
    }
}
