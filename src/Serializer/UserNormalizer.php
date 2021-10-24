<?php

namespace App\Serializer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserNormalizer implements ContextAwareNormalizerInterface
{
    public function __construct(private ObjectNormalizer $normalizer) {
    }

    /**
     * @param array<string, mixed> $data
     * @param string|null $format
     * @phpstan-param  array<mixed> $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($data, string $format = null, array $context = []): mixed
    {
        $data = $this->normalizer->normalize($data, $format, $context);
        /** @phpstan-var array<string, mixed> $data */
        $data['email'] = $this->secureEmail($data['email'] ?? '');
        return $data;
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @phpstan-param  array<mixed> $context
     * @return bool
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof User;
    }

    // format email@gmail.com to e***l@gmail.com
    private function secureEmail(string $email): string
    {
        $em   = explode("@",$email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        return $name[0] . str_repeat('*', strlen($name) - 2) . $name[strlen($name) - 1] . "@" . end($em);
    }
}