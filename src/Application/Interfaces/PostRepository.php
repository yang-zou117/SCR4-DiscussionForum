<?php

namespace Application\Interfaces;

interface PostRepository {
    public function getPostsForDiscussion(int $discussionId): array;
    public function getPostsForSearchTerm(string $searchTerm): array;
    public function getLastPost(): ? \Application\Entities\Post;
    public function addNewPost(string $user, string $content, int $discussionId): bool;
    public function getPostsForUser(string $user) : array;
    public function getPostForId(int $id): ? \Application\Entities\Post;
    public function deletePost(int $id): bool;
}