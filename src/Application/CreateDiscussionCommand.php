<?php

namespace Application;

class CreateDiscussionCommand {

    const ERROR_NOT_SIGNED_IN = 0x01;
    const ERROR_TITLE_EMPTY = 0x02;
    const ERROR_NO_INITIAL_POST = 0x04;
    const ERROR_CREATION_FAILED = 0x08;

    public function __construct(
        private \Application\Interfaces\DiscussionRepository $discussionRepository,
        private \Application\SignedInUserQuery $signedInUserQuery
    ){}

    public function execute(string $topicTitle, string $initialPostContent): int{
        $error = 0; 
        
        $user = $this->signedInUserQuery->execute();
        if ($user === null) {
            $error |= self::ERROR_NOT_SIGNED_IN;
        }

        if (empty($topicTitle)) {
            $error |= self::ERROR_TITLE_EMPTY;
        }

        if (empty($initialPostContent)) {
            $error |= self::ERROR_NO_INITIAL_POST;
        }

        if ($error === 0) {
            $res = $this->discussionRepository->addNewDiscussion($topicTitle, 
                                        $initialPostContent, $user->userName);
            if (!$res) {
                $error |= self::ERROR_CREATION_FAILED;
            }
        }

        return $error;
    }
}