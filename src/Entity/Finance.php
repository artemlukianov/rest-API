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
    private float $balance = 0;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="finance")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected \DateTime $createdAt;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->createdAt = new \DateTime();
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
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

    public function addToBalance(float $amount): void
    {
        $this->balance = $this->balance + $amount;
    }

    public function chargeBalance(float $amount): void
    {
        $this->balance = $this->balance - $amount;
    }
}