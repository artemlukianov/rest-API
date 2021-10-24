<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class IsBalanceValidValidator extends ConstraintValidator
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (! $constraint instanceof IsBalanceValid) {
            throw new UnexpectedTypeException($constraint, IsBalanceValid::class);
        }

        if (! $value || ! ((\is_float($value)) || (\is_int($value)))) {
            return;
        }

        /** @phpstan-var User $user */
        $user = $this->tokenStorage->getToken()?->getUser();

        if ($value > $user->getFinance()->getBalance()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
