<?php

namespace Infrastructure;

class Repository
implements 
    \Application\Interfaces\UserRepository, 
    \Application\Interfaces\DiscussionRepository,
    \Application\Interfaces\PostRepository
{

    private $server;
    private $userName;
    private $password;
    private $database;

    public function __construct(string $server, string $userName, 
                                string $password, string $database) {
        $this->server = $server;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
    }

    // === private helper methods ===

    private function getConnection() {
        $con = new \mysqli($this->server, $this->userName, 
                           $this->password, $this->database);
        if (!$con) {
            die('Unable to connect to database. Error: ' . mysqli_connect_error());
        }
        return $con;
    }

    private function executeQuery($connection, $query){
        $result = $connection->query($query);
        if (!$result) {
            die("Error in query '$query': " . $connection->error);
        }
        return $result;
    }

    private function executeStatement($connection, $query, $bindFunc){
        $statement = $connection->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query': " . $connection->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query': " . $statement->error);
        }
        return $statement;
    }

    // === public methods of userRepository ===

    public function getUser(int $id) : ?\Application\Entities\User {
        $connection = $this->getConnection();
        $query = "SELECT * FROM users WHERE id = ?"; 
        $statement = $this->executeStatement($connection, $query, function($statement) use ($id) {
            $statement->bind_param('i', $id);
        });
        $result = $statement->get_result();
        $user = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user = new \Application\Entities\User($row['id'], $row['userName'], $row['passwordHash']);
        }
        $connection->close();
        return $user;
    }

    public function findUserForUserName(string $userName): ?\Application\Entities\User {
        $connection = $this->getConnection();
        $query = "SELECT * FROM users WHERE BINARY userName = ?";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($userName) {
            $statement->bind_param('s', $userName);
        });
        $result = $statement->get_result();
        $user = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user = new \Application\Entities\User($row['id'], $row['userName'], $row['passwordHash']);
        }
        $connection->close();
        return $user;
    }

    public function createUser(string $userName, string $passwordHash): bool {
        $connection = $this->getConnection();
        $query = "INSERT INTO users (userName, passwordHash) VALUES (?, ?)";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($userName, $passwordHash) {
            $statement->bind_param('ss', $userName, $passwordHash);
        });
        $connection->commit();
        $connection->close();
        return true;
    }

    // === public methods of DiscussionRepository  ===
    public function getAllDiscussions(): array {
        $connection = $this->getConnection(); 
        $query = "SELECT * FROM Discussions INNER JOIN (
            SELECT Discussions.did, Count(pid) AS numberOfPosts 
            FROM Discussions INNER JOIN Posts 
            ON Discussions.did = Posts.did GROUP BY did
        ) AS countTable ON Discussions.did = countTable.did;"; 
        $result = $this->executeQuery($connection, $query);
        $discussions = [];
        while ($row = $result->fetch_assoc()) {
            $discussion = new \Application\Entities\Discussion($row['did'], $row['topic'], 
                $row['startUser'], $row['startDateTime'], $row['lastUser'], $row['lastDateTime'],
                $row['numberOfPosts']);
            $discussions[] = $discussion;
        }
        $connection->close();
        return $discussions;
    }

    public function addNewDiscussion(string $topicTitle, string $initialPostContent, string $user): bool {
        $connection = $this->getConnection();
        $query = "INSERT INTO Discussions (topic, startUser, startDateTime, lastUser, lastDateTime) VALUES (?, ?, NOW(), ?, NOW())";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($topicTitle, $user) {
            $statement->bind_param('sss', $topicTitle, $user, $user);
        });
        $discussionId = $connection->insert_id;
        $query = "INSERT INTO Posts (content, author, createdAt, did) VALUES (?, ?, NOW(), ?)";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($initialPostContent, $user, $discussionId) {
            $statement->bind_param('ssi', $initialPostContent, $user, $discussionId);
        });
        $connection->commit();
        $connection->close();
        return true;
    }

    public function getTopicForId(int $id): ?string {
        $connection = $this->getConnection();
        $query = "SELECT topic FROM Discussions WHERE did = ?";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($id) {
            $statement->bind_param('i', $id);
        });
        $result = $statement->get_result();
        $topic = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $topic = $row['topic'];
        }
        $connection->close();
        return $topic;
    }

    public function getDiscussionsForUser(string $user): array {
        $connection = $this->getConnection(); 
        $query = "SELECT * FROM Discussions INNER JOIN (
            SELECT Discussions.did, Count(pid) AS numberOfPosts 
            FROM Discussions INNER JOIN Posts 
            ON Discussions.did = Posts.did GROUP BY did
        ) AS countTable ON Discussions.did = countTable.did WHERE startUser = ?";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($user) {
            $statement->bind_param('s', $user);
        });
        $result = $statement->get_result();
        $discussions = [];
        while ($row = $result->fetch_assoc()) {
            $discussion = new \Application\Entities\Discussion($row['did'], $row['topic'], 
                $row['startUser'], $row['startDateTime'], $row['lastUser'], $row['lastDateTime'],
                $row['numberOfPosts']);
            $discussions[] = $discussion;
        }
        $connection->close();
        return $discussions;
    }

    public function getDiscussionForId(int $id): ? \Application\Entities\Discussion {   
        $connection = $this->getConnection(); 
        $query = "SELECT * FROM Discussions INNER JOIN (
            SELECT Discussions.did, Count(pid) AS numberOfPosts 
            FROM Discussions INNER JOIN Posts 
            ON Discussions.did = Posts.did GROUP BY did
        ) AS countTable ON Discussions.did = countTable.did WHERE countTable.did = ?";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($id) {
            $statement->bind_param('i', $id);
        });
        $result = $statement->get_result();
        $discussion = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $discussion = new \Application\Entities\Discussion($row['did'], $row['topic'], 
                $row['startUser'], $row['startDateTime'], $row['lastUser'], $row['lastDateTime'],
                $row['numberOfPosts']);
        }
        $connection->close();
        return $discussion;
    }

    public function deleteDiscussion(int $id): bool {
        $connection = $this->getConnection();
        $query = "DELETE FROM Discussions WHERE did = ?";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($id) {
            $statement->bind_param('i', $id);
        });
        $connection->commit();
        $connection->close();
        return true;
    }

    
    // === public methods of PostRepository  ===
    public function getPostsForDiscussion(int $discussionId): array {
        $connection = $this->getConnection(); 

        $query = "SELECT * FROM Posts WHERE did = ? ORDER BY createdAt";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($discussionId) {
            $statement->bind_param('i', $discussionId);
        });
        $result = $statement->get_result();
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $post = new \Application\Entities\Post($row['pid'], $row['author'], 
                $row['createdAt'], $row['content'], $this->getTopicForId($row['did']), $row['did']);
            $posts[] = $post;
        }
        $connection->close();
        return $posts;
    }

    public function getPostsForSearchTerm(string $searchTerm): array {

        // insert % as wildcard before and after the search term
        $searchTerm = '%' . $searchTerm . '%';

        $connection = $this->getConnection(); 
        $query = "SELECT * FROM Posts WHERE content LIKE ? ORDER BY createdAt";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($searchTerm) {
            $statement->bind_param('s', $searchTerm);
        });
        $result = $statement->get_result();
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $post = new \Application\Entities\Post($row['pid'], $row['author'], 
                $row['createdAt'], $row['content'], $this->getTopicForId($row['did']), $row['did']);
            $posts[] = $post;
        }
        $connection->close();
        return $posts;
    }

    public function getLastPost(): ? \Application\Entities\Post {
        $connection = $this->getConnection(); 
        $query = "SELECT * FROM Posts ORDER BY createdAt DESC LIMIT 1";
        $result = $this->executeQuery($connection, $query);
        $post = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $post = new \Application\Entities\Post($row['pid'], $row['author'], 
                $row['createdAt'], $row['content'], $this->getTopicForId($row['did']), $row['did']);
        }
        $connection->close();
        return $post;
    }

    public function addNewPost(string $user, string $content, int $discussionId): bool {
        $connection = $this->getConnection();
        $query = "INSERT INTO Posts (content, author, createdAt, did) VALUES (?, ?, NOW(), ?)";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($content, $user, $discussionId) {
            $statement->bind_param('ssi', $content, $user, $discussionId);
        });
        $connection->commit();
        $connection->close();
        return true;
    }

    public function getPostsForUser(string $user) : array {
        $connection = $this->getConnection(); 
        $query = "SELECT * FROM Posts WHERE author = ? ORDER BY createdAt";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($user) {
            $statement->bind_param('s', $user);
        });
        $result = $statement->get_result();
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $post = new \Application\Entities\Post($row['pid'], $row['author'], 
                $row['createdAt'], $row['content'], $this->getTopicForId($row['did']), $row['did']);
            $posts[] = $post;
        }
        $connection->close();
        return $posts;
    }

    public function getPostForId(int $id): ? \Application\Entities\Post {
        $connection = $this->getConnection(); 
        $query = "SELECT * FROM Posts WHERE pid = ?";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($id) {
            $statement->bind_param('i', $id);
        });
        $result = $statement->get_result();
        $post = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $post = new \Application\Entities\Post($row['pid'], $row['author'], 
                $row['createdAt'], $row['content'], $this->getTopicForId($row['did']), $row['did']);
        }
        $connection->close();
        return $post;
    }

    public function deletePost(int $id): bool {
        $connection = $this->getConnection();
        $query = "DELETE FROM Posts WHERE pid = ?";
        $statement = $this->executeStatement($connection, $query, function($statement) use ($id) {
            $statement->bind_param('i', $id);
        });
        $connection->commit();
        $connection->close();
        return true;
    }

}