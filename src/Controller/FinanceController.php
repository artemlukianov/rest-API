<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\TransferFinanceForm;
use App\Repository\UserRepository;
use App\Service\FinanceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method User getUser()
 */
final class FinanceController extends AbstractController
{
    public function __construct(private FinanceService $financeService, private NormalizerInterface $normalizer, private ValidatorInterface $validator) {
    }

    #[Route(path: "/api/finance/transfer", methods: ["POST"])]
    public function transfer(Request $request): Response
    {
        $form = (new TransferFinanceForm())->mapFromArray($request->toArray());
        $errors = $this->validator->validate($form);

        if ($errors->count() > 0) {
            return new Response((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $transaction = $this->financeService->transfer($this->getUser(), $form);

        return $this->json($this->normalizer->normalize($transaction, 'json', ['groups' => 'transaction-history']));
    }
}