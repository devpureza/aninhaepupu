<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFilamentAdmin extends Command
{
    protected $signature = 'make:admin';
    
    protected $description = 'Create Mateus admin user for Filament';

    public function handle()
    {
        $email = 'devpureza@gmail.com';
        
        if (User::where('email', $email)->exists()) {
            $this->error('Admin user already exists!');
            return 1;
        }

        $user = User::create([
            'name' => 'Mateus Pureza',
            'email' => $email,
            'password' => Hash::make('Garuga@2'),
            'email_verified_at' => now(),
        ]);

        $this->info('✅ Admin user created successfully!');
        $this->info("📧 Email: {$user->email}");
        $this->info("🔑 Password: Garuga@2");
        $this->info("🌐 Login: /admin");

        return 0;
    }
}
