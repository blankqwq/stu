<?php

namespace App\Mail;

use App\Message;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestJoinClass extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $user;
    /**
     * Create a new message instance.
     *申请加入班级发送邮件
     * @return void
     */
    public function __construct(User $user,Message $message)
    {
        $this->message=$message;
        $this->user=$user;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.joinclass');
    }
}
