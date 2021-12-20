<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Http\Request;

class InfoTutup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'info:tutup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show modal to inform user that the e-commerce is close order';

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
    public function handle(Request $request)
    {
        // $request = new Request();

        $request->session()->put('info','Diki Alfarabi Hadi');


        // \Log::info("Cron is working fine!");
        // $this->info('Demo:Cron Cummand Run successfully!');
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
      
    }
}
