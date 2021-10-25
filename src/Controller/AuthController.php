<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User getUser()
 */
final class AuthController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route(path: "/api/logout", methods: ["POST"])]
    public function logout(): Response
    {
        $this->em->persist($this->getUser()->setHash(uniqid()));
        $this->em->flush();
        return $this->json(['message' => 'User logged out']);
    }
}