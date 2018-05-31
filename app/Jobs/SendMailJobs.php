<?php

namespace App\Jobs;

use App\Classes;
use App\Mail\MessageRemind;
use App\Message;
use App\MessageType;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class SendMailJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $users;
    public $message;
    public $classe;
    public $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Classes $classes,Message $message,MessageType $messageType)
    {
        $this->users=$classes->users()->get();
        $this->message=$message;
        $this->classe=$classes;
        $this->type=$messageType;
        //
    }

    /**
     * Execute the job.
     *给每一个用户发送提示邮件
     * @return void
     */
    public function handle()
    {
        foreach($this->users as $user){
            Mail::to($user)->send(new MessageRemind($this->message,$this->classe,$this->type));
        }
        //
    }
}
