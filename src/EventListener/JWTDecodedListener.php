<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTDecodedListener
{
    public function __construct(private RequestStack $requestStack, private UserRepository $userRepository)
    {
    }

    public function onJWTDecoded(JWTDecodedEvent $event): void
    {
        $payload = $event->getPayload();
        if (! (isset($payload['username']) || isset($payload['hash']))) {
            $event->markAsInvalid();
        }

        $user = $this->userRepository->findOneBy(['username' => $payload['username']]);

        if ($user?->getHash() !== $payload['hash']) {
            $event->markAsInvalid();
        }
    }
}