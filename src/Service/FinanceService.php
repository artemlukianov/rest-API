<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\TransactionsHistory;
use App\Entity\User;
use App\Form\TransferFinanceForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

final class FinanceService
{
    public function __construct(private UserRepository $repository, private EntityManagerInterface $em)
    {
    }

    /**
     * @param User $user
     * @param TransferFinanceForm $form
     * @return TransactionsHistory
     * @throws EntityNotFoundException
     */
    public function transfer(UserInterface $user, TransferFinanceForm $form): TransactionsHistory
    {
        $recipientUser = $this->repository->findOneBy(['username' => $form->getUsername()]);

        if (! $recipientUser) {
            throw new EntityNotFoundException();
        }

        $recipientUser->getFinance()->addToBalance($form->getAmount());
        $user->getFinance()->chargeBalance($form->getAmount());

        $transaction = (new TransactionsHistory())
            ->setAmount($form->getAmount())
            ->setSender($user)
            ->setRecipientUsername($recipientUser->getUsername());

        $this->em->persist($transaction);
        $this->em->flush();

        return $transaction;
    }
}