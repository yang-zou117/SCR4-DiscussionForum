<?php
namespace Application;

class DiscussionsForUserQuery{

    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\Interfaces\DiscussionRepository $discussionRepository
    ){}

    public function execute(): ? array {
        $user = $this->signedInUserQuery->execute();
        if($user === null) {
            return null; // not signed in
        } else {
            $result = [];
            $queryResult = $this->discussionRepository->getDiscussionsForUser($user->userName);
            foreach($queryResult as $d) {
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
}