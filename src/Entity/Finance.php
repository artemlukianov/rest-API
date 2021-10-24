<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="finances")
 * @ORM\Entity
 */
class Finance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float", length=255, options={"default": 0})
     * @Groups("view")
     */
    private int|float $balance = 0;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="finance")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getBalance(): float|int
    {
        return $this->balance;
    }

    public function setBalance(float|int $balance): self
    {
        $this->balance = $balance;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function addToBalance(int|float $amount): void
    {
        $this->balance = $this->balance + $amount;
    }

    public function chargeBalance(int|float $amount): void
    {
        $this->balance = $this->balance - $amount;
    }
}