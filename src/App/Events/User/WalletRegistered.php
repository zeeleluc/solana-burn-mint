<?php
namespace App\Events\User;

use App\Events\BaseWalletEvent;
use App\Models\Wallet;

class WalletRegistered extends BaseWalletEvent
{

    public function __construct(Wallet $wallet)
    {
        parent::__construct($wallet);
    }
}
