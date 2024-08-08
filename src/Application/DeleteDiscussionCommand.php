<?php

namespace Application; 

class DeleteDiscussionCommand {

    const ERROR_NOT_SIGNED_IN = 0x01; 
    const ERROR_NOT_FOUND = 0x02;
    const ERROR_NO_PERMISSION = 0x04;
    const ERROR_DELETE_FAILED = 0x08;
    
    public function __construct(
        private \Application\SignedInUserQuery $signedInUser,
        private \Application\Interfaces\DiscussionRepository $discussionRepository
    )
    {}

    public function execute(int $discussionId) : int {
        $errors = 0; 

        $user = $this->signedInUser->execute();
        if ($user === null) {
            $errors |= self::ERROR_NOT_SIGNED_IN;
        }

        $discussion = $this->discussionRepository->getDiscussionForId($discussionId);
        if ($discussion === null) {
            $errors |= self::ERROR_NOT_FOUND;
        } else {
            if ($discussion->getStartUser() !== $user->userName) {
                $errors |= self::ERROR_NO_PERMISSION;
            }
        }

        if ($errors === 0) {
            if (!$this->discussionRepository->deleteDiscussion($discussionId)) {
                $errors |= self::ERROR_DELETE_FAILED;
            }
        }

        return $errors;
    }

    
    
}