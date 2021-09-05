<?php

namespace App\Console\Commands;

use App\Http\Controllers\Auth\UserPermission;
use Illuminate\Console\Command;

class ServePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve already existing permission for users';

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
        $permission = new UserPermission();
        $permission->servePermission();
        return $this->info('All the permission is successfully distribute');
    }
}
