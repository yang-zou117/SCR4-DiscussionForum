<?php
namespace Application; 

class PostsForUserQuery {

    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\Interfaces\PostRepository $postRepository
    ){}

    public function execute(): ? array {
        $user = $this->signedInUserQuery->execute();
        if ($user === null) {
            return null; // no user signed in
        }

        $result = []; 
        $queryResult = $this->postRepository->getPostsForUser($user->userName);
        foreach ($queryResult as $post) {
            $result[] = new PostData(
                $post->getId(),
                $post->getAuthor(),
                $post->getCreatedAt(),
                $post->getContent(),
                $post->getTopic(),
                $post->getDiscussionId()
            );
        }
        return $result;

    }
}