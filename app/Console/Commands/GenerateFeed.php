<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\GoogleFeedExport;

class GenerateFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fme:feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate csv Google Product feed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        set_time_limit(0);
        ini_set('memory_limit', -1);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return (new GoogleFeedExport)->download('google-feed' . date('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
