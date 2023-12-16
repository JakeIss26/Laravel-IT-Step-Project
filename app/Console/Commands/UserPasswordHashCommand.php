<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Command;
use App\Models\User;

class UserPasswordHashCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-password-hash-command';

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
        $users = User::all();
        foreach ($users as $user)
        {
            $user->password = Hash::make($user->password);
            $user->save();
        }

    }
}
