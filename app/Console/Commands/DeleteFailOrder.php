<?php

namespace App\Console\Commands;

use App\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class DeleteFailOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:fail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Fail Order';

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
        $orders = Order::where('created_at', '<', Carbon::now()->subDays(7))->deactive()->get();
        foreach ($orders as $order) {
            $order->delete();
            Log::info('deleted_Order:'.$order->id);
        }
    }
}
