<?php

namespace Application; 

class PostsSearchQuery {

    public function __construct(
        private \Application\Interfaces\PostRepository $postRepository,
    ){}

    public function execute(string $searchTerm): array {
        $posts = $this->postRepository->getPostsForSearchTerm($searchTerm);
        $result = [];
        foreach($posts as $p) {
            $result[] = new PostData(
                $p->getId(),
                $p->getAuthor(),
                $p->getCreatedAt(),
                $p->getContent(),
                $p->getTopic(),
                $p->getDiscussionId()
            );
        }
        return $result;
    }
}
