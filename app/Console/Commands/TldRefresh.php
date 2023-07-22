<?php

namespace App\Console\Commands;

use App\Http\Helper\HelperTLD;
use App\Models\User;
use Illuminate\Console\Command;

class TldRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tld:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userJawaly = User::whereNotNull('host_bill_id')->first();
        HelperTLD::availableTLD($userJawaly);
    }
}
