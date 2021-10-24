<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="transactions_history")
 * @ORM\Entity
 */
class TransactionsHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float", length=255, options={"default": 0})
     * @Groups({"view", "transaction-history"})
     */
    private int|float $amount = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactionsHistory", cascade={"refresh"})
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id", nullable=false)
     * @Groups({"view", "transaction-history"})
     */
    private User $sender;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     * @Groups({"view", "transaction-history"})
     */
    private string $recipientUsername;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"view", "transaction-history"})
     */
    protected \DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getAmount(): float|int
    {
        return $this->amount;
    }

    public function setAmount(float|int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getSender(): User
    {
        return $this->sender;
    }

    public function setSender(User $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getRecipientUsername(): string
    {
        return $this->recipientUsername;
    }

    public function setRecipientUsername(string $recipientUsername): self
    {
        $this->recipientUsername = $recipientUsername;
        return $this;
    }
}