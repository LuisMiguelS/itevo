<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create admin';

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
        $user = User::create([
            'name' => $this->ask('What is your name ?') ?? 'Administrador',
            'email' => $this->ask('What is yor email ?') ?? 'admin@system.com',
            'password' => $this->secret('Your password ? (Default "secret")') ?? 'secret',
        ]);

        Bouncer::assign('admin')->to($user);

        $this->info("Name: {$user->name} email: {$user->email}");
    }
}
