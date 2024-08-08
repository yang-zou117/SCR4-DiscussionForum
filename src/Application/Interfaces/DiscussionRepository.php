<?php

namespace Application\Interfaces;

interface DiscussionRepository {
    public function getAllDiscussions(): array;
    public function addNewDiscussion(string $topicTitle, string $initialPostContent, string $user): bool;
    public function getTopicForId(int $id): ?string;
    public function getDiscussionsForUser(string $user): array;
    public function getDiscussionForId(int $id): ? \Application\Entities\Discussion;
    public function deleteDiscussion(int $id): bool;
}