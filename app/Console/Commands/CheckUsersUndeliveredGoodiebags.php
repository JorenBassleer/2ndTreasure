<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Goodiebag;
class CheckUsersUndeliveredGoodiebags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkUsersUndelivered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if user has more than 10 undelivered goodiebags and flag if so';

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
        // Get all normal users
        $users = User::onlyNormalUsers()->get();
        foreach($users as $user) {
            // Get amount of undelivered goodiebags of the user
            $amount = Goodiebag::where('user_id', $user->id)
                            ->whereIn('hasReceived', [null, 0])->count();
            // If user has more than 15 undelivered goodiebags
            if($amount > 10) {
                $user->isFlagged = 1;
                $user->save();
            }
        }
    }
}
