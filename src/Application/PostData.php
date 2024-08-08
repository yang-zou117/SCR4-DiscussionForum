<?php

namespace Application; 

class PostData {
    public function __construct(
        public int $id,
        public string $author,
        public string $createdAt,
        public string $content, 
        public string $topic,
        public string $discussionId
    ){}
  
}