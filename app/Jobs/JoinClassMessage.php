<?php

namespace App\Jobs;

use App\Mail\RequestJoinClass;
use App\Message;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class JoinClassMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    public $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,Message $message)
    {
        $this->user=$user;
        $this->message=$message;
        //
    }

    /**
     * Execute the job.
     *发送邮件加入队列
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new RequestJoinClass($this->user,$this->message));
    }
}
