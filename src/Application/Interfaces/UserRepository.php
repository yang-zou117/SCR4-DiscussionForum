<?php

namespace Application\Interfaces;

interface UserRepository {
    public function getUser(int $id) : ?\Application\Entities\User;
    public function findUserForUserName(string $username): ?\Application\Entities\User; 
    public function createUser(string $username, string $passwordHash): bool; 
}