<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class UserController extends AbstractController
{
    public function __construct(private NormalizerInterface $normalizer) {
    }

    #[Route(path: "/api/user/info", methods: ["GET"])]
    public function info(): Response
    {
        return $this->json($this->normalizer->normalize($this->getUser(), 'json', ['groups' => 'view']));
    }
}