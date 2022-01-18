<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class appClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all app cache, config, views, routes';

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
        Artisan::call('view:clear');
        Artisan::call('view:cache');
        $this->comment('Views have been cleared!');

        Artisan::call('route:clear');
        Artisan::call('route:cache');
        $this->comment('Routes have been cleared!');

        Artisan::call('config:clear');
        Artisan::call('config:cache');
        $this->comment('Config have been cleared!');

        Artisan::call('cache:clear');
        $this->comment('Cache have been cleared!');

        Artisan::call('clear-compiled');
        $this->comment('Compiled classes have been cleared!');

        Artisan::call('optimize:clear');
        $this->comment('Optimize have been cleared!');

        $this->comment('App have been cleared!');
        return 1;
    }
}
