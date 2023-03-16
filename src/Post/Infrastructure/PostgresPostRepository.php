<?php

declare(strict_types=1);

namespace App\Post\Infrastructure;

use App\Post\Domain\Post;
use App\Post\Domain\PostRepository;
use App\Shared\Infrastructure\Persistence\DoctrineBaseRepository;
use Symfony\Component\Uid\Uuid;

class PostgresPostRepository extends DoctrineBaseRepository implements PostRepository
{
    public function save(Post $post): void
    {
        $this->persist($post);
    }

    public function find(Uuid $uuid): ?Post
    {
        return $this->repository(Post::class)->find($uuid);
    }
}
