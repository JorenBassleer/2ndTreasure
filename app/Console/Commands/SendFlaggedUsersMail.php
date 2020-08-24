<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\FlaggedUsersMail;
use App\Mail\ForFlaggedUsersMail;
use App\User;
use Config;
class SendFlaggedUsersMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendFlaggedUsersMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to admin and user that the user has been flagged as a bad user';

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
     * @return int
     */
    public function handle()
    {
        $flaggedUsers = User::onlyNormalUsers()->where('isFlagged', 1)->get();

        // Send mail to admin
        try {
            Mail::to(config('mail.from.address'))
            ->send(new FlaggedUsersMail($flaggedUsers));
        } catch(Exception $e) {
            return $e;
        }
        // If there is any
        if(count($flaggedUsers) > 0) {
            // Send mail to flagged users
            foreach($flaggedUsers as $flaggedUser) {
                try {
                    Mail::to($flaggedUser->email)
                            ->send(new ForFlaggedUsersMail());
                } catch( Exception $e) {
                    return $e;
                }
            }
        }
    }
}
