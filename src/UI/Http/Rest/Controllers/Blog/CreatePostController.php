<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controllers\Blog;

use App\Application\Blog\CreatePostUseCase;
use App\Application\Blog\Dto\PostDto;
use App\Domain\Blog\Exception\PostValidation;
use App\Domain\User\Exception\UserNotFound;
use App\Domain\User\UserRepository;
use App\UI\Http\Rest\Controllers\BaseRestController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class CreatePostController extends BaseRestController
{
    public function __construct(private readonly CreatePostUseCase $createPostUseCase, private readonly UserRepository $userRepository, RequestStack $request)
    {
        parent::__construct($request);
    }

    /**
     * @throws PostValidation
     * @throws UserNotFound
     */
    #[OA\Response(response: 201, description: 'Resource created successfully', content: new OA\JsonContent(properties: [new OA\Property(property: 'message', type: 'string', example: 'Post Created')], type: 'object'))]
    #[OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(properties: [new OA\Property(property: 'title', type: 'string', example: 'An error occurred'), new OA\Property(property: 'detail', type: 'string', example: 'User with id: 1eedc701-19b4-6e18-a217-c7016adb3940 not found'), new OA\Property(property: 'code', type: 'integer', example: 404)], type: 'object'))]
    #[OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(properties: [new OA\Property(property: 'title', type: 'string', example: 'An error occurred'), new OA\Property(property: 'detail', type: 'string', example: 'Post validation error'), new OA\Property(property: 'code', type: 'integer', example: 422), new OA\Property(property: 'errors', type: 'array', items: new OA\Items(properties: [new OA\Property(property: 'field', type: 'string', example: 'user_id'), new OA\Property(property: 'title', type: 'string', example: 'This value should not be blank'), new OA\Property(property: 'detail', type: 'string', example: 'This value should not be blank')], type: 'object'))], type: 'object'))]
    #[OA\RequestBody(description: 'Body to create a post', required: true, content: new OA\MediaType(mediaType: 'application/x-www-form-urlencoded', schema: new OA\Schema(required: ['user_id', 'title', 'body'], properties: [new OA\Property(property: 'user_id', description: 'User id', type: 'string', format: 'uuid'), new OA\Property(property: 'title', description: 'Title of the post', type: 'string'), new OA\Property(property: 'body', description: 'Body of the post', type: 'string')], type: 'object')))]
    #[OA\Tag(name: 'Blog')]
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
        $constraint = new Assert\Collection(['user_id' => [new Assert\NotBlank(), new Assert\Uuid()], 'body' => [new Assert\NotBlank()], 'title' => [new Assert\NotBlank()]]);
        $validator = Validation::createValidator();

        $errors = $validator->validate($data, $constraint);

        if (count($errors) > 0) {
            throw new PostValidation($errors);
        }
    }
}
