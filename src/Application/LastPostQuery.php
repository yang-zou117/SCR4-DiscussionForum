<?php
namespace Application;

class LastPostQuery {

    public function __construct( 
        private \Application\Interfaces\PostRepository $postRepository
    )
    {}

    public function execute(): ? \Application\PostData {
        $post = $this->postRepository->getLastPost();
        if($post === null) {
            return null;
        } 
        return new \Application\PostData(
            $post->getId(),
            $post->getAuthor(),
            $post->getCreatedAt(),
            $post->getContent(),
            $post->getTopic(),
            $post->getDiscussionId()
        );
    }

}