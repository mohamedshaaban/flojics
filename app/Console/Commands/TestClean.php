<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use system;
class TestClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue:dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       system('npm -v') ;
       echo system('npm run dev') ;
        system('npm -v') ;

    }
}
