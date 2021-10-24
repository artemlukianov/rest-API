<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

final class UserForm
{
    #[
        Assert\NotBlank, Assert\Type('string'), Assert\Length(min: 6, max: 32),
        Assert\Regex(
            pattern: '[A-Za-z]',
            message: 'Only latin alphabet allowed',
            match: false,
        )
    ]
    private ?string $username = null;

    #[Assert\NotBlank, Assert\Length(min: 8, max: 255)]
    private ?string $password = null;

    #[Assert\Email, Assert\Length(max: 45)]
    private ?string $email = null;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @phpstan-param array<string, string> $data
     */
    public function fromArray(array $data): self
    {
        $this->password = $data['password'] ?? '';
        $this->username = $data['username'] ?? '';
        $this->email = $data['email'] ?? '';
        return $this;
    }

    public function toEntity(): User
    {
        return (new User())
            ->setEmail($this->email ?? '')
            ->setPassword($this->password ?? '')
            ->setUsername($this->username ?? '');
    }
}