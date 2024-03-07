<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controllers\Blog;

use App\Application\Blog\CreatePostUseCase;
use App\Application\Blog\Dto\PostDto;
use App\Domain\Blog\Exception\PostValidation;
use App\Domain\User\Exception\UserNotFound;
use App\Domain\User\UserRepository;
use App\UI\Http\Rest\Controllers\BaseRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class CreatePostController extends BaseRestController
{
    public function __construct(
        private readonly CreatePostUseCase $createPostUseCase,
        private readonly UserRepository $userRepository,
        RequestStack $request
    ) {
        parent::__construct($request);
    }

    /**
     * @throws PostValidation
     * @throws UserNotFound
     */
    #[Route('/v1/blog', methods: [Request::METHOD_POST])]
    public function index(Request $request): Response
    {
        $this->validateRequest($request);

        $data = $request->request->all();

        $user = $this->userRepository->find(Uuid::fromString($data['user_id']));
        if (!$user) {
            throw new UserNotFound($data['user_id']);
        }
        $dto = PostDto::create($data['title'], $data['body']);

        $this->createPostUseCase->execute($dto, $user);

        return $this->json(['message' => 'Post created'], 201);
    }

    /**
     * @throws PostValidation
     */
    private function validateRequest(Request $request): void
    {
        $data = $request->request->all();
        $constraint = new Assert\Collection([
            'user_id' => [
                new Assert\NotBlank(),
                new Assert\Uuid()
            ],
            'body' => [
                new Assert\NotBlank(),
            ],
            'title' => [
                new Assert\NotBlank(),
            ],
        ]);
        $validator = Validation::createValidator();

        $errors = $validator->validate($data, $constraint);

        if (count($errors) > 0) {
            throw new PostValidation($errors);
        }
    }
}
