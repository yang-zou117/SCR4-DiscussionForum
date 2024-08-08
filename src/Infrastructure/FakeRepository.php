<?php

namespace Infrastructure;

class FakeRepository implements 
    \Application\Interfaces\DiscussionRepository, 
    \Application\Interfaces\PostRepository, 
    \Application\Interfaces\UserRepository
{

    private $mockDiscussions; 
    private $mockPosts; 
    private $mockUsers;

    public function __construct() {
        $this->mockDiscussions = array(
            array(1, 'What is the role of government in society?', 'scr4', '2021-01-01 12:00:00', 'Johnny', '2021-01-01 12:00:00', 1), // post counter and last user fake
            array(2, 'What do you think about the future of space exploration?', 'timoline', '2021-01-21 12:00:00', 'haleluja', '2021-01-31 12:00:00', 3),
            array(3, 'How many languages can a person learn? ', 'Johnny', '2021-02-01 12:00:00', 'Johnny', '2021-03-01 12:00:00', 30),
            array(4, 'USA: Is American Dream dead?', 'XTYY', '2020-01-01 12:00:00', 'DollarTrump', '2023-10-30 12:00:00', 100),
            array(5, 'Why are apple products so expensive?', 'scr4', '2015-08-21 12:39:10', 'Johnny', '2019-07-31 08:00:00', 3),
            array(6, 'Why is the sky blue?', 'timoline', '2015-04-01 12:30:00', 'SwaHupf', '2019-07-31 08:00:00', 100),
        );

        $this->mockPosts = array (
            array(1, 'scr4', '2021-01-01 11:02:30', 'In my opinion, the role of government is to protect the people from each other.
                          What do you think about it?', 1),
            array(2, 'timoline', '2021-01-21 12:00:00', 'I think that the future of space exploration is very bright. 
                          We will be able to colonize Mars in the next 20 years.', 2),
            array(3, 'haleluja', '2021-06-01 12:40:00', 'I think that we will be able to colonize Mars in the next 100 years.', 2),
            array(4, 'Steve', '2021-05-30 08:00:00', 'I am not sure about that. I think that we will be able to colonize Mars in the next 100 years.', 2),
            array(13, 'Freak', '2023-04-23 04:33:58', 'I believe that we will conquer the whole universe in the next 1000 years.', 2),
            array(14, 'haleluja', '2023-05-01 09:33:58', 'With the advance of technology, 
            the human being will be able to travel from planet to planet, just like in Start Wars', 2),
            array(5, 'Johnny', '2021-02-01 12:00:45', 'I think that a person can learn 2-3 languages. 
                          After that, it is very difficult to learn a new language.', 3),
            array(6, 'Truman', '2023-03-31 04:39:00', 'From my experience, I can say that it is possible to learn 5-6 languages. 
                          I speak 6 languages fluently.', 3),
            array(7, 'XTYY', '2020-01-01 14:00:23', 'I think that the American Dream is still alive. 
                          It is just that the dream has changed. 
                          Now the dream is to have a good job and a nice house.', 4),
            array(8, 'Donald Trump', '2023-10-30 12:01:10', 'I think that the American Dream is dead. Our wealth is decreasing and our jobs are being outsourced to other 
                            countries. We need to bring back our jobs. Let\'s make America great again!', 4),
            array(9, 'WhoRan', '20215-08-01 12:30:00', 'I think that apple products are so expensive because they are very good.
                            I have an iPhone and I am very happy with it.', 5),
            array(10, 'Noname', '2019-07-31 08:00:00', 'From my point of view, the price policy of Apple is absolutely unfair and unacceptable. 
                            They view the customers just as cashcows and are making a lot of money on their customers whilie evading taxes.', 5),
            array(11, 'WhoRan', '2015-04-01 12:30:00', 'They reason why the sky is blue because of the scattering of light by the molecules of the atmosphere.', 6),
            array(12, 'SwaHupf', '2019-07-31 08:36:40', 'I believe that you are right.', 6),

        );

        $this->mockUsers = array(
            array(1, 'scr4', '$2y$10$0dhe3ngxlmzgZrX6MpSHkeoDQ.dOaceVTomUq/nQXV0vSkFojq.VG')
        );
    }


    public function getAllDiscussions(): array
    {
        $result = [];
        foreach($this->mockDiscussions as $d) {
            $result[] = new \Application\Entities\Discussion(
                $d[0], $d[1], $d[2], $d[3], $d[4], $d[5], $d[6]
            );
        }
        
        return $result;  
    }

    public function getDiscussionForId(int $id): ? \Application\Entities\Discussion {
        foreach($this->mockDiscussions as $d) {
            if ($d[0] == $id) {
                return new \Application\Entities\Discussion(
                    $d[0], $d[1], $d[2], $d[3], $d[4], $d[5], $d[6]
                );
            }
        }
        return null;
    }


    public function addNewDiscussion(string $topicTitle, string $initialPostContent, string $user): bool {
        
        $this->mockDiscussions[] = array(
            count($this->mockDiscussions) + 1, $topicTitle, $user, date('Y-m-d H:i:s'), $user, date('Y-m-d H:i:s'), 0
        );

        return true;
    }

    public function deleteDiscussion(int $id): bool
    {
        foreach($this->mockDiscussions as $d) {
            if ($d[0] == $id) {
                $key = array_search($d, $this->mockDiscussions);
                unset($this->mockDiscussions[$key]);
                return true;
            }
        }
        return false; 
    }

    public function getPostsForDiscussion(int $discussionId): array
    {
        $result = [];
        foreach($this->mockPosts as $p) {
            if ($p[4] == $discussionId) {
                $result[] = new \Application\Entities\Post(
                    $p[0], $p[1], $p[2], $p[3], $this->getTopicForId($p[4]), $p[4]
                );
            }
        }

        // sort by date
        usort($result, function($a, $b) {
            $a_time = strtotime($a->getCreatedAt());
            $b_time = strtotime($b->getCreatedAt());
            if ($a_time == $b_time) {
                return 0;
            }
            return ($a_time < $b_time) ? -1 : 1;
        });

        return $result;  
    }

    public function getPostsForSearchTerm(string $searchTerm): array {
        $result = [];
        if(empty($searchTerm)) {
            return $result;
        }
        foreach($this->mockPosts as $p) {
            if (strpos($p[3], $searchTerm) !== false) {
                $result[] = new \Application\Entities\Post(
                    $p[0], $p[1], $p[2], $p[3], $this->getTopicForId($p[4]), $p[4]
                );
            }
        }   

        // sort by date
        usort($result, function($a, $b) {
            $a_time = strtotime($a->getCreatedAt());
            $b_time = strtotime($b->getCreatedAt());
            if ($a_time == $b_time) {
                return 0;
            }
            return ($a_time < $b_time) ? -1 : 1;
        });

        return $result;  
        
    }

    public function getLastPost(): ? \Application\Entities\Post {
        $lastPost = null;
        foreach($this->mockPosts as $p) {
            if($lastPost === null) {
                $lastPost = $p;
            } else {
                if(strtotime($p[2]) > strtotime($lastPost[2])) {
                    $lastPost = $p;
                }
            }
        }
        if($lastPost === null) {
            return null;
        }
        return new \Application\Entities\Post(
            $lastPost[0], $lastPost[1], $lastPost[2], $lastPost[3], $this->getTopicForId($lastPost[4]), $lastPost[4]
        );
    }

    public function getPostForId(int $id): ? \Application\Entities\Post {
        foreach($this->mockPosts as $p) {
            if ($p[0] == $id) {
                return new \Application\Entities\Post(
                    $p[0], $p[1], $p[2], $p[3], $this->getTopicForId($p[4]), $p[4]
                );
            }
        }
        return null;
    }

    public function addNewPost(string $content, string $user, int $discussionId): bool {
        // add new post to mockPosts
        $this->mockPosts[] = array(
            count($this->mockPosts) + 1, $user, date('Y-m-d H:i:s'), $content, $discussionId
        );
        return true;
    }

    public function deletePost(int $id): bool {
        foreach($this->mockPosts as $p) {
            if ($p[0] == $id) {
                $key = array_search($p, $this->mockPosts);
                unset($this->mockPosts[$key]);
                return true; 
            }
        }
        return false; 
    }



    public function findUserForUserName(string $username): ?\Application\Entities\User {
        foreach($this->mockUsers as $u) {
            if($u[1] === $username) {
                return new \Application\Entities\User($u[0], $u[1], $u[2]);
            }
        }
        return null;
    }

    public function getUser(int $id): ?\Application\Entities\User {
        foreach($this->mockUsers as $u) {
            if($u[0] === $id) {
                return new \Application\Entities\User($u[0], $u[1], $u[2]);
            }
        }
        return null;
    }

    public function createUser(string $username, string $passwordHash): bool {
        // TODO: data base stuff
        $this->mockUsers[] = array(count($this->mockUsers) + 1, $username, $passwordHash); // does not work 
        return true;
    }

    public function getDiscussionsForUser(string $user): array {
        $result = [];
        foreach($this->mockDiscussions as $d) {
            if ($d[2] == $user) {
                $result[] = new \Application\Entities\Discussion(
                    $d[0], $d[1], $d[2], $d[3], $d[4], $d[5], $d[6]
                );
            }
        }
        return $result;
    }

    public function getPostsForUser(string $user) : array {
        $result = [];
        foreach($this->mockPosts as $p) {
            if ($p[1] == $user) {
                $result[] = new \Application\Entities\Post(
                    $p[0], $p[1], $p[2], $p[3], $this->getTopicForId($p[4]), $p[4]
                );
            }
        }
        return $result;
    }




    public function getTopicForId(int $discussionId): string{
        foreach($this->mockDiscussions as $d) {
            if ($d[0] == $discussionId) {
                return $d[1];
            }
        }
        return '';
    }

}

