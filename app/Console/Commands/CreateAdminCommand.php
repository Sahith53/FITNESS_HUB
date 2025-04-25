<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {name} {email} {password} {phone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $phone = $this->argument('phone');

        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'profile_pic' => '1.png',
                'role' => 'admin'
            ]);

            $this->info('Admin user created successfully!');
        } catch (\Exception $e) {
            $this->error('Error creating admin user: ' . $e->getMessage());
        }
    }
}
