<?php

namespace App\Jobs;

use App\Classes;
use App\Mail\RequestJoinClass;
use App\Message;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendToClassRoleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $users;
    public $message;
    public $classe;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Classes $classes,Message $message)
    {
        $this->users=$classes->users()->get();
        $this->classe=$classes;
        $this->message=$message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->users as $user){
            if ($user->hasRole($this->classe->id))
                Mail::to($user)->send(new RequestJoinClass($user,$this->message));
        }
    }
}
