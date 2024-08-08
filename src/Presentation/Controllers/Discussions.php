<?php

namespace Presentation\Controllers;

final class Discussions extends \Presentation\MVC\Controller{

    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery, 
        private \Application\LastPostQuery $lastPostQuery,
        private \Application\CreateDiscussionCommand $createDiscussionCommand,
        private \Application\DeleteDiscussionCommand $deleteDiscussionCommand, 
        private \Application\DiscussionsForUserQuery $discussionsForUserQuery,
        private \Application\PostsForUserQuery $postsForUserQuery,
    ){}

    public function GET_NewDiscussion(): \Presentation\MVC\ViewResult {
        
        return $this->view('newDiscussion', [
            'user' => $this->signedInUserQuery->execute(), 
            'active' => 'New Discussion',
            'lastPost' => $this->lastPostQuery->execute()
        ]);

    }

    public function POST_NewDiscussion(): \Presentation\MVC\ActionResult {
        
        $topicTitle = $this->getParam('topicTitle');
        $postContent = $this->getParam('postContent');
        
        $result = $this->createDiscussionCommand->execute($topicTitle, $postContent);
        if($result != 0) {
            $errors = []; 

            if($result & \Application\CreateDiscussionCommand::ERROR_NOT_SIGNED_IN) {
                $errors[] = 'You must be signed in to create a discussion.';
            }

            if($result & \Application\CreateDiscussionCommand::ERROR_TITLE_EMPTY) {
                $errors[] = 'Title must not be empty.';
            }

            if($result & \Application\CreateDiscussionCommand::ERROR_NO_INITIAL_POST) {
                $errors[] = 'You must provide an initial post.';
            }

            if($result & \Application\CreateDiscussionCommand::ERROR_CREATION_FAILED) {
                $errors[] = 'Failed to create discussion.';
            }

            return $this->view('newDiscussion', [
                'active' => 'NewDiscussion',
                'errors' => $errors, 
                'user' => $this->signedInUserQuery->execute(),
                'lastPost' => $this->lastPostQuery->execute()
            ]);

        }

        // discussion created --> redirect to home page
        return $this->redirect('Home', 'Index');
    }

    public function POST_DeleteDiscussion(): \Presentation\MVC\ActionResult{
        $discussionId = $this->getParam('did');
        $result = $this->deleteDiscussionCommand->execute($discussionId);
        if($result != 0) {
            $errors = []; 

            if($result & \Application\DeleteDiscussionCommand::ERROR_NOT_SIGNED_IN) {
                $errors[] = 'You must be signed in to delete a discussion.';
            }

            if($result & \Application\DeleteDiscussionCommand::ERROR_NOT_FOUND) {
                $errors[] = 'Discussion not found.';
            }

            if($result & \Application\DeleteDiscussionCommand::ERROR_NO_PERMISSION) {
                $errors[] = 'You do not have permission to delete this discussion.';
            }

            if($result & \Application\DeleteDiscussionCommand::ERROR_DELETE_FAILED) {
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