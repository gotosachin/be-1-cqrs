<?php

declare(strict_types=1);

namespace App\Post\Application\Command;

use App\Post\Domain\Post;
use App\Post\Domain\PostRepository;
use App\Shared\Domain\Bus\CommandHandler;

class CreatePostCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke(CreatePostCommand $command): void
    {
        $post = Post::new(
            id: $command->id,
            title: $command->title,
            summary: $command->summary,
        );
        $this->repository->save($post);
    }
}
