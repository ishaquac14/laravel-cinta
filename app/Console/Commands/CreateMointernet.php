<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mointernet;

class CreateMointernet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mointernet:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create MoInternet data daily at 00:01';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = 1;
        $duration = 0;
        Mointernet::create([
            'user_id' => $userId,
            'date' => now()->toDateString(),
            'start_time', 
            'end_time', 
            'root_cause', 
            'duration' => $duration 
        ]);

        $this->info('Mointernet data created successfully.');
    }
}
