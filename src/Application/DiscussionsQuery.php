<?php

namespace Application; 

final class DiscussionsQuery {

    public function __construct(
        private Interfaces\DiscussionRepository $discussionRepository
    ){}

    public function execute(): array {
        $result = [];
        foreach($this->discussionRepository->getAllDiscussions() as $d) {
            $result[] = new DiscussionData(
                $d->getId(),
                $d->getTopic(),
                $d->getStartUser(),
                $d->getStartDateTime(),
                $d->getLastUser(),
                $d->getLastDateTime(),
                $d->getNumberOfPosts()
            );
        }
        return $result;
    }
}