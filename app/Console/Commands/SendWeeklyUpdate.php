<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
class SendWeeklyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendWeeklyUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly update to users that requested this';

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
        return 0;
    }
}
