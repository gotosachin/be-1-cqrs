<?php

declare(strict_types=1);

namespace App\Post\Domain;

use Symfony\Component\Uid\Uuid;

interface PostRepository
{
    public function save(Post $post): void;

    public function find(Uuid $uuid): ?Post;
}
