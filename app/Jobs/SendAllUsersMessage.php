<?php

namespace App\Jobs;

use App\Mail\RequestJoinClass;
use App\MessageType;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendAllUsersMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ids;
    public $input;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ids,$input)
    {
        $this->input=$input;
        $this->ids=$ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

            foreach ($this->ids as $id){
                try{
                    $user=User::find($id);
                    if ($user){
                        $message=$user->messages()->create($this->input);
                        Mail::to($user)->send(new RequestJoinClass($user,$message));
                    }
                }catch (\Exception $exception){

                }
            }
        }
}
