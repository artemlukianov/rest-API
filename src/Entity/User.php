<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users", indexes={
 *  @ORM\Index(name="username_email_idx", columns={"username", "email"})
 * })
 * @ORM\Entity
 * @UniqueEntity({"email", "username"})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     * @Groups({"view", "transaction-history"})
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min=6, max=32)
     * @Assert\Regex(
     *   pattern="[A-Za-z]",
     *   message="Only latin alphabet allowed",
     *   match=false,
     *  )
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=8, max=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=45, unique=true)
     * @Groups({"view", "transaction-history"})
     * @Assert\Email
     * @Assert\Length(max=45)
     */
    private string $email;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Finance", mappedBy="user", cascade={"persist"})
     * @Groups("view")
     */
    private Finance $finance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TransactionsHistory", mappedBy="sender", cascade={"persist"})
     * @phpstan-var Collection<int,TransactionsHistory>
     * @Groups({"view"})
     */
    private Collection $transactionsHistory;

    public function __construct()
    {
        $this->finance = new Finance($this);
        $this->transactionsHistory = new ArrayCollection();
    }

    /**
     * @phpstan-return Collection<int,TransactionsHistory>
     */
    public function getTransactionsHistory(): Collection
    {
        return $this->transactionsHistory;
    }

    public function addTransactionHistory(TransactionsHistory $transactionHistory): self
    {
        $this->transactionsHistory->add($transactionHistory);
        return $this;
    }

    public function getFinance(): Finance
    {
        return $this->finance;
    }

    public function setFinance(Finance $finance): self
    {
        $this->finance = $finance;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @phpstan-return array<string>
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        $this->password = '';
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
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
}