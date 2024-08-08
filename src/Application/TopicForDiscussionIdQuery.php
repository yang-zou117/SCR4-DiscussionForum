<?php

namespace Application;

class TopicForDiscussionIdQuery {

    public function __construct(
        private \Application\Interfaces\DiscussionRepository $discussionRepository
    ){}

    public function execute(int $discussionId): ?string {
        return $this->discussionRepository->getTopicForId($discussionId);
    }

}