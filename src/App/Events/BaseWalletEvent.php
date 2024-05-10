<?php

namespace App\Events;

use App\Models\Wallet;

abstract class BaseWalletEvent extends BaseEvent
{

    public function __construct(private readonly Wallet $user)
    {

    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }
}
