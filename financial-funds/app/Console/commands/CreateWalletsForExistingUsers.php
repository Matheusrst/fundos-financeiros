<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Wallet;

class CreateWalletsForExistingUsers extends Command
{
    protected $signature = 'create:wallets';

    protected $description = 'Create wallets for existing users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::doesntHave('wallet')->get();

        foreach ($users as $user) {
            $user->wallet()->create(['balance' => 0]);
        }

        $this->info('Wallets created for existing users.');
    }
}
