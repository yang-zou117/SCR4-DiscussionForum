<?php 
// === register autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});


$sp = new ServiceProvider; 

// ====== Application =========
$sp->register(\Application\AddPostCommand::class);
$sp->register(\Application\CreateDiscussionCommand::class);
$sp->register(\Application\DeleteDiscussionCommand::class);
$sp->register(\Application\DeletePostCommand::class);
$sp->register(\Application\DiscussionsQuery::class);
$sp->register(\Application\DiscussionsForUserQuery::class);
$sp->register(\Application\LastPostQuery::class);
$sp->register(\Application\PostsForDiscussionQuery::class);
$sp->register(\Application\PostsForUserQuery::class);
$sp->register(\Application\PostsSearchQuery::class);
$sp->register(\Application\RegisterUserCommand::class);
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignOutCommand::class);
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\TopicForDiscussionIdQuery::class);
// Services
$sp->register(\Application\Services\AuthenticationService::class, isSingleton: true);

// ====== Infrastructure ======
// MySQL repository
$sp->register(\Infrastructure\Repository::class, function() {return new \Infrastructure\Repository('localhost', 'root', '', 'discussionforum');}, isSingleton: true);
$sp->register(\Application\Interfaces\DiscussionRepository::class, \Infrastructure\Repository::class); 
$sp->register(\Application\Interfaces\PostRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class);

$sp->register(\Infrastructure\Session::class, isSingleton: true); // !!! 
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);


// ====== Presentation ========
$sp->register(\Presentation\MVC\MVC::class, function(){ return new \Presentation\MVC\MVC(); });
$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\Posts::class);
$sp->register(\Presentation\Controllers\User::class);
$sp->register(\Presentation\Controllers\Discussions::class);


// ====== handle request ======
$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);