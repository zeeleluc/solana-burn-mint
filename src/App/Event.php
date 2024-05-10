<?php

namespace App;

use App\Events\BaseEvent;
use App\Events\User\WalletRegistered;
use App\Models\BaseModel;

class Event
{

    /**
     * @throws \Exception
     */
    public static function do(string $eventClass, BaseModel $model)
    {
        $event = new $eventClass;
        $listeners = self::getListenersForEvent($event);

        foreach ($listeners as $listener) {
            (new $listener((new $event($model))))->do();
        }
    }

    /**
     * @throws \Exception
     */
    private static function getListenersForEvent(BaseEvent $event): array
    {
        $listeners = [
            WalletRegistered::class => [
                // listeners
            ],
        ];

        if (!array_key_exists($event::class, $listeners)) {
            throw new \Exception('No listeners found for ` . $event::class . `');
        }

        return $listeners[$event::class];
    }
}
