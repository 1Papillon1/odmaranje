<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;

class AddActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-activity';

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
        Activity::create([
            'name' => 'Sleep',
            'description' => 'Rest and rejuvenate by sleeping.',
            'energy_change' => 96, 
            'duration' => 480, 
        ]);

        $this->info('Sleep activity added successfully!');
    }
}
