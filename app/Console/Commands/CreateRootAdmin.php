<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateRootAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:adminAccount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $first_name = 'tran';
        $last_name ='quoc hao';
        $email = 'tranquochao0102@gmail.com';
        $password = Hash::make('haotran0101');

        User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
            'role' => 'admin'
        ]);

        $this->info('Root admin created successfully!');
    }
    
}
