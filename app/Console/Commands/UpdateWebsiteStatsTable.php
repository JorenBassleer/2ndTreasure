<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Goodiebag;
use App\WebsiteStats;
class UpdateWebsiteStatsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateWebsiteStats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the stats of the website';

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
        // Amount of foodbanks
        $foodbanksAmount = User::onlyFoodbanks()->count();
        // Amount of normal users
        $usersAmount = User::onlyNormalUsers()->count();
        // Amount of food donated
        $donatedAmount = Goodiebag::where('hasReceived', 1)->sum('total_kg');
        $totalTreasures = Goodiebag::where('hasReceived', 1)->sum('treasures');
        // Create a new one so we can track overtime
        // how the website is doing
        WebsiteStats::create([
            'amount_of_foodbanks' => $foodbanksAmount,
            'amount_of_users' =>$usersAmount,
            'amount_of_kg_donated' => $donatedAmount,
            'amount_of_treasures_created' => $totalTreasures,
        ]);
    }
}
