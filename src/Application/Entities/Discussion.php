<?php

namespace Application\Entities;

class Discussion {
    public function __construct(
        private int $id,
        private string $topic,
        private string $startUser,
        private string $startDateTime,
        private string $lastUser,
        private string $lastDateTime,
        private int $numberOfPosts
    ) {}

    public function getId(): int {
        return $this->id;
    }

    public function getTopic(): string {
        return $this->topic;
    }

    public function getStartUser(): string {
        return $this->startUser;
    }

    public function getStartDateTime(): string {
        return $this->startDateTime;
    }

    public function getLastUser(): string {
        return $this->lastUser;
    }

    public function getLastDateTime(): string {
        return $this->lastDateTime;
    }

    public function getNumberOfPosts(): int {
        return $this->numberOfPosts;
    }
    
}