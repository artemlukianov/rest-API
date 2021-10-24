<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class UserController extends AbstractController
{
    public function __construct(private NormalizerInterface $serializer) {
    }

    #[Route(path: "/api/user/info", methods: ["GET"])]
    public function info(): Response
    {
        return $this->json($this->serializer->normalize($this->getUser(), 'json', ['groups' => 'view']));
    }
}