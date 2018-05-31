<?php

namespace App\Mail;

use App\Classes;
use App\Message;
use App\MessageType;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageRemind extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *这是一个消息提醒，发送邮件通过jobs（队列）来进行分发
     * @return void
     */
    public $message,$classe,$type;

    public function __construct(Message $message,Classes $classe,MessageType $type)
    {
        $this->message=$message;
        $this->classe=$classe;
        $this->type=$type;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->classe->name.$this->type->category.'：'.$this->message->title)
        ->view('mail.test')->with([
            'content'=>$this->message->content,
        ]);
    }
}
