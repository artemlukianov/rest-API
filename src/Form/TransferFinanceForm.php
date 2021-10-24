<?php
declare(strict_types=1);

namespace App\Form;

use App\Validator\IsBalanceValid;
use Symfony\Component\Validator\Constraints as Assert;

final class TransferFinanceForm
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min=8, max=255)]
     */
    private string $username = '';

    /**
     * @Assert\NotBlank
     * @Assert\Type("double")
     * @Assert\NotEqualTo(value=0)
     * @IsBalanceValid
     */
    private int|float $amount = 0;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }


    public function getAmount(): int|float
    {
        return $this->amount;
    }

    public function setAmount(int|float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @phpstan-param array<string, string> $data
     */
    public function mapFromArray(array $data): self
    {
        $this->username = $data['username'] ?? '';
        $this->amount = isset($data['amount']) ? (float) $data['amount'] : 0;
        return $this;
    }
}