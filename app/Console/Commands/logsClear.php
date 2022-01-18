<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class logsClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear log files';

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
        exec('rm -f ' . storage_path('logs/*.log'));

        exec('rm -f ' . base_path('*.log'));

        $this->comment('Logs have been cleared!');
        return 1;
    }
}
