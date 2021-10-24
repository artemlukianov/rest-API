<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RegisterController extends AbstractController
{
    public function __construct(private ValidatorInterface $validator,
                                private UserPasswordHasherInterface $encoder,
                                private EntityManagerInterface $em,
                                private NormalizerInterface $normalizer
    ){
    }

    #[Route(path: "/api/register", methods: ["POST"])]
    public function register(Request $request): Response
    {
        $user = (new User())
            ->fromArray($request->toArray());

        $errors = $this->validator->validate($user);

        if ($errors->count() > 0) {
            return new Response((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->setPassword($this->encoder->hashPassword($user, $user->getPassword()));
        $this->em->persist($user);
        $this->em->flush();

        return $this->json($this->normalizer->normalize($user, 'json', ['groups' => 'view']), Response::HTTP_CREATED);
    }
}