<?php
namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TopUpUserBalanceCommand extends Command
{
    protected static $defaultName = 'app:top-up-user-balance';

    public function __construct(private UserRepository $repository,
                                private EntityManagerInterface $em,
                                private ValidatorInterface $validator,
                                string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription("Top up user balance vai email")
            ->addArgument('email',InputArgument::REQUIRED, 'User password')
            ->addArgument('amount',InputArgument::REQUIRED, 'Amount of top up');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->repository->findOneBy(['email' => $input->getArgument('email')]);
        if (! $user) {
            $output->writeln(sprintf("User with email: %s not found", $input->getArgument('email')));
            return Command::INVALID;
        }
        $amount = (float) $input->getArgument('amount');
        $errors = $this->validator->validate($amount, new Assert\Type("float"));

        if ($errors->count() > 0) {
            $output->writeln($errors);
            return Command::INVALID;
        }

        if ($amount == 0) {
            $output->writeln("Amount must be number that is not equal to 0");
            return Command::INVALID;
        }

        $user->getFinance()->addToBalance($amount);
        $this->em->persist($user);
        $this->em->flush();

        $output->writeln(sprintf("Success. Balance of user %s top upped for %s", $user->getEmail(), $amount));
        return Command::SUCCESS;
    }
}