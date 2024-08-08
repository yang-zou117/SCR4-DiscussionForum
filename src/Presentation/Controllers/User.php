<?php

namespace Presentation\Controllers; 

final class User extends \Presentation\MVC\Controller {

    public function __construct(
        private \Application\SignInCommand $signInCommand,
        private \Application\SignOutCommand $signOutCommand, 
        private \Application\SignedInUserQuery $signedInUserQuery, 
        private \Application\RegisterUserCommand $registerUserCommand,
        private \Application\LastPostQuery $lastPostQuery, 
        private \Application\DiscussionsForUserQuery $discussionsForUserQuery, 
        private \Application\PostsForUserQuery $postsForUserQuery
    ){}

    public function GET_LogIn(): \Presentation\MVC\ViewResult {
        return $this->view('login', [
            'user' => $this->signedInUserQuery->execute(), 
            'userName' => '',
            'active' => 'LoginSignUp',
            'lastPost' => $this->lastPostQuery->execute(),
            'registerSuccess' => $this->tryGetParam('registerSuccess', $value) ? $value : null
        ]);
    }

    public function GET_Register(): \Presentation\MVC\ViewResult {
        return $this->view('register', [
            'active' => 'LoginSignUp', 
            'user' => $this->signedInUserQuery->execute(),
            'lastPost' => $this->lastPostQuery->execute()
        ]);
    }

    public function POST_LogIn(): \Presentation\MVC\ActionResult {
        $input_name = $this->getParam('un');
        $input_pwd = $this->getParam('pwd');
        if (!$this->signInCommand->execute($input_name, $input_pwd)) {
            // login failed --> show login form again
            return $this->view('login', [
                'userName' => $input_name,  
                'user' => $this->signedInUserQuery->execute(), 
                'errors' => ['Invalid user name or password'],
                'active' => 'LoginSignUp',
                'lastPost' => $this->lastPostQuery->execute()
            ]);
        }
        // login successful --> redirect to home page
        return $this->redirect('Home', 'Index');
    } 

    public function POST_LogOut(): \Presentation\MVC\RedirectResult {
        $this->signOutCommand->execute();
        return $this->redirect('User', 'Login');
    }

    public function POST_Register(): \Presentation\MVC\ActionResult {

        $sel_name = $this->tryGetParam('register_name', $value) ? $value : ""; 
        $sel_pwd = $this->getParam('register_pwd');
        $sel_pwd_repeat = $this->getParam('repeat_pwd');
        $sel_check = $this->tryGetParam('registerCheck', $value) ? $value : false;

        $result = $this->registerUserCommand->execute($sel_name, $sel_pwd, $sel_pwd_repeat, $sel_check);
        if($result !== 0) {
            $errors = [];

            if($result & \Application\RegisterUserCommand::ERROR_USERNAMEEMPTY) {
                $errors[] = 'User name is empty';
            }

            if($result & \Application\RegisterUserCommand::ERROR_USERNAMEALREADYEXISTS) {
                $errors[] = 'User name already exists';
            }
            if($result & \Application\RegisterUserCommand::ERROR_PASSWORDNOTSECURE) {
                $errors[] = 'Password not secure enough (at least 8 characters, digits and numbers required)';
            }
            if($result & \Application\RegisterUserCommand::ERROR_PASSWORDSDONTMATCH) {
                $errors[] = 'Passwords don\'t match';
            }
            if($result & \Application\RegisterUserCommand::ERROR_TERMSNOTACCEPTED) {
                $errors[] = 'Terms and conditions not accepted';
            }
            return $this->view('register', [
                'register_name' => $sel_name,
                'active' => 'LoginSignUp',
                'errors' => $errors,
                'lastPost' => $this->lastPostQuery->execute(),
            ]);
        }

        // register successful --> redirect to login page
        return $this->redirect('User', 'Login', [
            'registerSuccess' => true
        ]);
    }


    public function GET_DiscussionPostsOfUser(): \Presentation\MVC\ViewResult {
        
        return $this->view('userDiscussionPosts', [
            'active' => 'myDiscussionPosts',
            'user' => $this->signedInUserQuery->execute(), 
            'lastPost' => $this->lastPostQuery->execute(), 
            'discussions' => $this->discussionsForUserQuery->execute(), 
            'discussionsOfOneUser' => true, 
            'posts' => $this->postsForUserQuery->execute(), 
            'postsOfOneUser' => true,
            'errors' => $this->tryGetParam('errors', $value) ? $value : null,
            'deletedSuccess' => $this->tryGetParam('deletedSuccess', $value) ? $value : null
        ]);

    }

    

}