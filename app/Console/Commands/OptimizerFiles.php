<?php

namespace App\Console\Commands;

use App\Http\Controllers\OptimizerController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OptimizerFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimizer:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert video, img for workers, works';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = OptimizerController::optimize();

        Log::alert('optimizer' , ['result' => $result]);
    }
}
