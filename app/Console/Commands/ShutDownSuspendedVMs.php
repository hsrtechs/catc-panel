<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ShutDownSuspendedVMs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Manage:SuspendedServers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Under Construction';

    protected $model;

    /**
     * Create a new command instance.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->error('Under Construction.');
}
}
