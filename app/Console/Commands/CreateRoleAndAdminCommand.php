<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateRoleAndAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:admin';

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
        $roles = [
            ['name' => 'admin'],
            ['name' => 'user']
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']]);
        }

        $adminRole = Role::where('name', 'admin')->first();
        $email = 'admin@mail.ru';
        $password = '12345678';

        $user = User::firstOrCreate(
            [
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role_id' => $adminRole->id,
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->info("Администратор успешно создан!");
            $this->info("Email: $email");
            $this->info("Password: $password");
        } else {
            $this->info("Администратор уже существует");
        }
    }
}
