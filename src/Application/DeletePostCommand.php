<?php

namespace Application; 

class DeletePostCommand {

    const ERROR_NOT_SIGNED_IN = 0x01; 
    const ERROR_NOT_FOUND = 0x02;
    const ERROR_NO_PERMISSION = 0x04;
    const ERROR_DELETE_FAILED = 0x08;
    
    public function __construct(
        private \Application\SignedInUserQuery $signedInUser,
        private \Application\Interfaces\PostRepository $postRepository
    )
    {}

    public function execute(int $postId) : int {
        $errors = 0; 

        $user = $this->signedInUser->execute();
        if (!$user) {
            $errors |= self::ERROR_NOT_SIGNED_IN;
        }

        $post = $this->postRepository->getPostForId($postId);
        if (!$post) {
            $errors |= self::ERROR_NOT_FOUND;
        }

        if ($post->getAuthor() !== $user->userName) {
            $errors |= self::ERROR_NO_PERMISSION;
        }

        if ($errors === 0) {
            if (!$this->postRepository->deletePost($postId)) {
                $errors |= self::ERROR_DELETE_FAILED;
            }
        }

        return $errors;
    }

}