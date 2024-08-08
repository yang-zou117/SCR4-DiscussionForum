<?php

namespace Presentation\Controllers; 


class Home extends \Presentation\MVC\Controller{

    public function __construct(
        private \Application\DiscussionsQuery $discussionsQuery, 
        private \Application\LastPostQuery $lastPostQuery,
        private \Application\SignedInUserQuery $signedInUserQuery
    ){}

    function GET_Index (): \Presentation\MVC\ViewResult {
        return new \Presentation\MVC\ViewResult('home', [
            'discussions' => $this->discussionsQuery->execute(), 
            'active' => 'Home',
            'lastPost' => $this->lastPostQuery->execute(), 
            'user' => $this->signedInUserQuery->execute()
        ]);
    }
    

}