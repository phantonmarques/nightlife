<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class Email extends Mailable
    {
        use Queueable, SerializesModels;

        public $mail;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct($mail)
        {
            $this->mail = $mail;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            if (!empty($this->mail->replyTo)) {
                return $this->subject($this->mail->subject)->replyTo($this->mail->replyTo)->view($this->mail->template, ['object' => $this->mail->object]);
            } else {
                return $this->subject($this->mail->subject)->view($this->mail->template, ['object' => $this->mail->object]);
            }
        }
    }
