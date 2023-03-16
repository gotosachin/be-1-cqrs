<?php

declare(strict_types=1);

namespace App\API;

use App\Post\Application\Command\CreatePostCommand;
use App\Post\Domain\Post;
use App\Post\Domain\PostRepository;
use App\Shared\Domain\Bus\CommandBus;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Uid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Post Controller, all route related to Post will be implemented here.
 */
class PostController extends AbstractController
{
    /**
     * @param CommandBus $commandBus
     * @param PostRepository $repository
     */
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly PostRepository $repository
    ) {
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route(path: '/posts', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $payload = $request->toArray();
            $title = $payload['title'] ?? null;

            if ($title && preg_match('#^Qwerty#i', $title) === 1) {
                throw new \Exception("Title starts with an illegal word!!", Response::HTTP_BAD_REQUEST);
            }

            $command = new CreatePostCommand(
                id: $payload['id'] ?? (string)Uuid::v4(),
                title: $payload['title'],
                summary: $payload['summary'],
            );

            $this->commandBus->dispatch(
                command: $command,
            );
        } catch (Exception $exception) {
            $exceptionCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_BAD_REQUEST;
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ],
                $exceptionCode,
            );
        }

        return new JsonResponse(
            [
                'post_id' => $command->id,
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @param string $postId
     *
     * @return JsonResponse
     */
    #[Route(path: '/posts/{postId}', methods: ['GET'])]
    public function find(string $postId): JsonResponse
    {
        try {
            /** @var Post $post */
            $uuid = Uuid::fromString($postId);
            $post = $this->repository->find($uuid);
            if (!$post) {
                throw new ResourceNotFoundException("Post #{$postId} not found!!", Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $exception) {
            $exceptionCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_NOT_FOUND;

            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ],
                $exceptionCode,
            );
        }

        return new JsonResponse(
            [
                'post_id' => $post->getId(),
                'title' => $post->getTitle(),
                'summary' => $post->getSummary(),

            ],
            Response::HTTP_OK,
        );
    }
}
