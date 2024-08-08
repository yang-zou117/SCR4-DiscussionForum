<?php

namespace Application;

readonly final class DiscussionData {

    public function __construct(
        public int $id,
        public string $topic,
        public string $startUser,
        public string $startDateTime,
        public string $lastUser,
        public string $lastDateTime,
        public int $numberOfPosts
    ) {}
}