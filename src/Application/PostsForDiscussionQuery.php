<?php

namespace Application;

class PostsForDiscussionQuery {

    public function __construct(
        private Interfaces\PostRepository $postRepository
    ){}

    public function execute(int $discussionId): array {
        $posts = $this->postRepository->getPostsForDiscussion($discussionId);
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