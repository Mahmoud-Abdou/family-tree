<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\WelcomeUser;

class WelcomeUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $VerifyUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $VerifyUser)
    {
        $this->user = $user;
        $this->VerifyUser = $VerifyUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to($this->user->email)->send(new WelcomeUser($this->user, $this->VerifyUser->token));
    }
}
