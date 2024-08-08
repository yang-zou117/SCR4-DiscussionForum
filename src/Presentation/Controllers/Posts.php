<?php

namespace Presentation\Controllers; 

final class Posts extends \Presentation\MVC\Controller {

    public function __construct(
       private \Application\PostsSearchQuery $postsSearchQuery,
       private \Application\PostsForDiscussionQuery $postsForDiscussionQuery, 
       private \Application\SignedInUserQuery $signedInUserQuery,
       private \Application\LastPostQuery $lastPostQuery,
       private \Application\AddPostCommand $addPostCommand, 
       private \Application\TopicForDiscussionIdQuery $topicForDiscussionIdQuery,
       private \Application\DiscussionsForUserQuery $discussionsForUserQuery,
       private \Application\PostsForUserQuery $postsForUserQuery,
         private \Application\DeletePostCommand $deletePostCommand
    ){}

    public function GET_Search(): \Presentation\MVC\ViewResult {

        return $this->view('search', [
            'active' => 'Search',
            'user' => $this->signedInUserQuery->execute(),
            'lastPost' => $this->lastPostQuery->execute(),
            'filter' => $this->tryGetParam('searchTerm', $value) ? $value : null,
            'posts' => $this->tryGetParam('searchTerm', $value) ? $this->postsSearchQuery->execute($value) : null
        ]);
    }

    public function GET_PostsOfDiscussion(): \Presentation\MVC\ViewResult {
        // get selected discussion id and topic
        $did = $this->tryGetParam('did', $value) ? $value : null;
        $scrollToPost = $this->tryGetParam('scrollToPost', $value) ? $value : null;

        return new \Presentation\MVC\ViewResult('postsOfDiscussion', [
            'posts' => $this->postsForDiscussionQuery->execute($did),
            'selectedTopic' => $this->topicForDiscussionIdQuery->execute($did),
            'did' => $did,
            'active' => 'Home', 
            'user' => $this->signedInUserQuery->execute(),
            'scrollToPost' => $scrollToPost,
            'lastPost' => $this->lastPostQuery->execute(), 
            'addPostSuccess' => $this->tryGetParam('addPostSuccess', $value) ? $value : null,
        ]);
    }

    public function POST_AddNewPost(): \Presentation\MVC\ActionResult{
        $postContent = $this->getParam('postContent');
        $did = $this->getParam('did');  

        $result = $this->addPostCommand->execute($did, $postContent);
        if($result != 0) {
            $errors = []; 
            if($result & \Application\AddPostCommand::ERROR_NOT_SIGNED_IN) {
                $errors[] = 'You must be signed in to post a message';
            }

            if($result & \Application\AddPostCommand::ERROR_NO_CONTENT) {
                $errors[] = 'You must enter a message to post';
            }

            if($result & \Application\AddPostCommand::ERROR_ADDING_POST_FAILED) {
                $errors[] = 'Adding new post failed';
            } 
        
            return $this->view('postsOfDiscussion', [
                'active' => 'Home',
                'errors' => $errors,
                'did' => $did,
                'lastPost' => $this->lastPostQuery->execute(),
                'user' => $this->signedInUserQuery->execute(),
                'posts' => $this->postsForDiscussionQuery->execute($did),
                'selectedTopic' => $this->topicForDiscussionIdQuery->execute($did),
            ]);

        }

        // post added --> redirect to posts of discussion page
        return $this->redirect('Posts', 'PostsOfDiscussion', [
            'did' => $did, 
            'addPostSuccess' => 'true'
        ]);
    }

    public function POST_DeletePost(): \Presentation\MVC\ActionResult{
        $postId = $this->getParam('pid');
        $result = $this->deletePostCommand->execute($postId);
        if($result != 0) {
            $errors = []; 

            if($result & \Application\DeletePostCommand::ERROR_NOT_SIGNED_IN) {
                $errors[] = 'You must be signed in to delete a discussion.';
            }

            if($result & \Application\DeletePostCommand::ERROR_NOT_FOUND) {
                $errors[] = 'Discussion not found.';
            }

            if($result & \Application\DeletePostCommand::ERROR_NO_PERMISSION) {
                $errors[] = 'You do not have permission to delete this discussion.';
            }

            if($result & \Application\DeletePostCommand::ERROR_DELETE_FAILED) {
                $errors[] = 'Failed to delete discussion.';
            }

            return $this->view('userDiscussionPosts', [
                'active' => 'myDiscussionPosts',
                'user' => $this->signedInUserQuery->execute(), 
                'lastPost' => $this->lastPostQuery->execute(), 
                'discussions' => $this->discussionsForUserQuery->execute(), 
                'discussionsOfOneUser' => true, 
                'posts' => $this->postsForUserQuery->execute(), 
                'postsOfOneUser' => true,
                'errors' => $errors
            ]);

        }

        // discussion deleted --> redirect to user's discussions
        return $this->redirect('User', 'DiscussionPostsOfUser', [
            'deletedSuccess' => true
        ]); 
    }

}