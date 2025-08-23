<?php

namespace App\Service;

use App\Entity\Post;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class PublicBlueskyApiService
{
    public function __construct(private HttpClientInterface $blueskyClient)
    {

    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getAuthorFeed(string $did): array
    {
        $response = $this->blueskyClient->request('GET', 'app.bsky.feed.getAuthorFeed', [
            'query' => [
                'actor' => $did,
            ]
        ]);

        $result = $response->toArray();

        if (!isset($result['feed'])) {
            return [];
        }

        $posts = [];

        foreach ($result['feed'] as ['post' => $data]) {
            $post = new Post();
            $post->cid = $data['cid'];
            $post->setCreatedAt($data['record']['createdAt']);
            $post->setText($data['record']['text']);
            $post->setUrl($this->getPostUrl($data['author']['handle'], $data['uri']));

            $posts[] = $post;
        }

        return $posts;
    }

    private function getPostUrl(string $handle, string $uri): string
    {
        $uriParts = explode('/', $uri);

        return sprintf(
            'https://bsky.app/profile/%s/post/%s',
            $handle,
            end($uriParts)
        );
    }
}
