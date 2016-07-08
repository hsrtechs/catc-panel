<?php

namespace App\Console\Commands;

use App\Task;
use hsrtech\catc\Wrapper;
use Illuminate\Console\Command;

class GetTasksFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the Tasks.';

    protected $table;

    protected $wrapper;

    /**
     * Create a new command instance.
     *
     * @param Task $task
     * @param Wrapper $wrapper
     */
    public function __construct(Task $task, Wrapper $wrapper)
    {
        parent::__construct();

        $this->table = $task;
        $this->wrapper = $wrapper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$tasks = $this->wrapper->getTasks();
        $this->error('Soon Be Constructed');
    }
}
