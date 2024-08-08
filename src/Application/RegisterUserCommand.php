<?php

namespace Application; 

class RegisterUserCommand{

    const ERROR_USERNAMEEMPTY = 0x01;
    const ERROR_USERNAMEALREADYEXISTS = 0x02; 
    const ERROR_PASSWORDNOTSECURE = 0x04;
    const ERROR_PASSWORDSDONTMATCH = 0x08;
    const ERROR_TERMSNOTACCEPTED = 0x10;
    const ERROR_CREATEUSERFAILED = 0x20;

    public function __construct(
        private Interfaces\UserRepository $userRepository, 
    ){}

    public function execute(string $username, string $password, 
                            string $passwordRepeat, bool $check): int {
        
        $errors = 0;

        // check if user name is empty
        if(strlen($username) == 0) {
            $errors |= self::ERROR_USERNAMEEMPTY;
        }

        // check if user name already exists
        $userId = $this->userRepository->findUserForUserName($username);
        if($userId != null) {
            $errors |= self::ERROR_USERNAMEALREADYEXISTS;
        } 

        // check if password is secure enough 
        // (at least 8 characters, digits and numbers required)
        if(strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) 
                                 || !preg_match('/[0-9]/', $password)) {
            $errors |= self::ERROR_PASSWORDNOTSECURE;
        }

        // check if passwords match
        if($password != $passwordRepeat) {
            $errors |= self::ERROR_PASSWORDSDONTMATCH;
        }

        // check if terms and conditions are accepted
        if(!$check) {
            $errors |= self::ERROR_TERMSNOTACCEPTED;
        }

        // if no errors, create user
        if($errors === 0) {
           $hash = password_hash($password, PASSWORD_DEFAULT);
           $res = $this->userRepository->createUser($username, $hash);
           if(!$res) { 
           $errors |= self::ERROR_CREATEUSERFAILED;
           }
        }
        
        return $errors;
    }

}