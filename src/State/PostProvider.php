<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Post;

class PostProvider implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $post = new Post();

        if ($operation instanceof CollectionOperationInterface) {
            $post->id = '2342rfuwsedgfhsdgf';
            return [$post];
        }

        $post->id = $uriVariables['id'];

        return $post;
    }
}
