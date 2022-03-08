<?php

namespace App\Console\Commands;

use App\Balance;
use App\Order;
use Illuminate\Console\Command;

class orderChangeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change order status';

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
        $orders = Order::where('status' , 'in the mandatory period')->get();

        foreach($orders as $order){

            $order->update([
                'status' => 'delivered'
            ]);

            $balance = Balance::where('user_id' , $order->user->id)->first();


            $balance->update([
                'outstanding_balance' => $balance->outstanding_balance  - $order->total_commission,
                'available_balance' => $balance->available_balance  + $order->total_commission,
            ]);




        }
    }
}
