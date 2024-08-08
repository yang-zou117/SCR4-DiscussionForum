<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <title>Discussion Forum</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4" id="nav-bar">
        <div class="container">
            <?php $link('SCR4 Forum', 'Home', 'Index', cssClass: 'navbar-brand ' . ($data['active'] == 'Home' ? 'active-link': '') ); ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <nav class="navbar-nav mr-auto">    
                <?php $link('Search', 'Posts', 'Search', cssClass: 'nav-link ' . ($data['active'] == 'Search' ? 'active-link': '')); ?>
                <?php $link('New Topic', 'Discussions', 'NewDiscussion', cssClass: 'nav-link ' . ($data['active'] == 'New Discussion' ? 'active-link': '')); ?>
                <?php $link('My Posts & Discussions', 'User', 'DiscussionPostsOfUser', cssClass: 'nav-link ' . ($data['active'] == 'myDiscussionPosts' ? 'active-link': '')); ?>
                </nav>
                <?php $render('partial/user', $data); ?> 
            </div>
        </div>
    </nav>
    <div class="container mb-3">