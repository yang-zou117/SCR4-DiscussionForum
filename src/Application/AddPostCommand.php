<?php

namespace Application;

class AddPostCommand{

    const ERROR_NOT_SIGNED_IN = 0x01; 
    const ERROR_NO_CONTENT = 0x02;
    const ERROR_ADDING_POST_FAILED = 0x04;

    public function __construct(
        private \Application\Interfaces\PostRepository $postRepository, 
        private \Application\SignedInUserQuery $signedInUserQuery
    ){}

    public function execute(int $discussionId, string $postContent): int {
        $error = 0; 
        $user = $this->signedInUserQuery->execute();
        if($user === null) {
            $error |= self::ERROR_NOT_SIGNED_IN;
        }

        if(empty($postContent)) {
            $error |= self::ERROR_NO_CONTENT;
        }

        if($error === 0) {
            $res = $this->postRepository->addNewPost($user->userName, $postContent, $discussionId);
            if(!$res) {
                $error |= self::ERROR_ADDING_POST_FAILED;
            }
        }
        
        return $error;
    }

}