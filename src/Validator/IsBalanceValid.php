<?php
declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @see IsBalanceValidValidator
 */
class IsBalanceValid extends Constraint
{
    public string $message = 'Balance invalid for this transaction';

    /** @var string */
    public string $className;

    public function validatedBy(): string
    {
        return IsBalanceValidValidator::class;
    }
}