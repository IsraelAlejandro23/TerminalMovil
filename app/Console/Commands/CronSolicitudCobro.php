<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\CronJobsController;

class CronSolicitudCobro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CronSolicitudCobro:enviarcorreo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia correo de solicitud de cobro a usuarios por parte del vendedor';

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
         $cron  = new CronJobsController;
         $cron->run();
    }
}
