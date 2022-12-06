<?php

namespace App\Console\Commands;

use App\File;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProductImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do the scheduled csv uploaded by admin';

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
     * @return mixed
     */
    public function handle()
    {
        $now   = Carbon::now();
        $files = File::where('type', "products")
            ->where('is_working', 0)
            ->where('is_queued', 0)
        //->where('scheduled_at', '<=', $now)
            ->whereNull('done_at')
            ->get();

        $this->comment("Scheduled Files Found: " . $files->count());

        foreach ($files as $file) {
            $this->comment("Sending file to queue with ID: " . $file->id);
            $file->is_queued = 1;
            $file->save();
            dispatch(new \App\Jobs\ProductImport($file));
        }

        return $this->call('queue:work', [
            '--queue'           => 'productimport', // remove this if queue is default
            '--stop-when-empty' => null,
            '--tries'           => 1,
            '--timeout'           => 0,
        ]);
    }
}
