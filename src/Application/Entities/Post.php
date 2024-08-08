<?php

namespace Application\Entities;

class Post {
    public function __construct(
        private int $id,
        private string $author,
        private string $createdAt,
        private string $content, 
        private string $topic,
        private int $discussionId
    ){}

    public function getId(): int {
        return $this->id;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function getTopic(): string {
        return $this->topic;
    }

    public function getDiscussionId(): int {
        return $this->discussionId;
    }
  
}