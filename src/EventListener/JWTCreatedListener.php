<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * Set hash to payload for future logout
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        /** @phpstan-var User $user */
        $user = $event->getUser();
        $payload = $event->getData();
        $payload['hash'] = $user->getHash();
        $event->setData($payload);
    }
}