<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\State\PostProvider;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(operations: [
    new Get(
        uriTemplate: '/posts/{id}',
    ),
    new GetCollection(
        uriTemplate: '/posts',
    )
], provider: PostProvider::class)]
class Post
{
    #[Assert\NotBlank]
    public ?string $id = null {
        get => $this->id;
        set(?string $id) => $this->id = $id;
    }
}
