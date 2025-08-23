<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\QueryParameter;
use App\State\PostProvider;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/posts',
            parameters: [
                'did' => new QueryParameter(
                    description: 'Author did',
                    required: true
                ),
            ]
        )
    ],
    provider: PostProvider::class
)]
class Post
{
    #[Assert\NotBlank]
    #[ApiProperty(identifier: true)]
    public ?string $cid = null {
        get => $this->cid;
        set(?string $cid) => $this->cid = $cid;
    }

    private DateTime $createdAt;
    private string $text;
    private string $url;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = new DateTime($createdAt);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
