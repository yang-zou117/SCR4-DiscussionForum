<?php

namespace Application;

class SignInCommand {

    public function __construct(
        private Interfaces\UserRepository $userRepository, 
        private Services\AuthenticationService $authenticationService
    ){}

    public function execute(string $username, string $password): bool {
        $this->authenticationService->signOut();
        $user = $this->userRepository->findUserForUserName($username);
        if($user != null && password_verify($password, $user->getPasswordHash())) {
            // user is now signed in
            $this->authenticationService->signIn($user->getId());
            return true;
        }
        return false; 
    }

}