<?php

namespace App\Policies;

use App\Models\User;
USE App\models\Stock;

class StockPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;    
        }
    }

    public function viewAny(user $user)
    {
        return $user->isUser();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Stock $stock)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Stock $stock)
    {
        return $user->isAdmin();
    }
}
