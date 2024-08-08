<?php $render('partial/header', $data); ?>


<h1 class="mb-4">Search Posts</h1>

<!-- Search Form -->
<div class="mb-3 col-md-7">
    <?php $beginForm('Posts', 'Search', cssClass: 'input-group'); ?>
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
        <input type="text" class="form-control" placeholder="Type a keyword" name="searchTerm">
        <div class="input-group-append">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </div>
    <?php $endForm(); ?>
</div>

<!-- Search Results -->
<div class="mt-5">
    <?php if (isset($data['posts'])): ?>
        <?php if (count($data['posts']) == 0): ?>
            <h3>No results found for ' <?php $htmlOut($data['filter'])?> '</h3>
        <?php else: ?>
            <h3>Results of ' <?php $htmlOut($data['filter'])?> '</h3>
            <hr class="border border-primary border-1 opacity-10">

            <!-- SearchPosts -->
            <?php $render('partial/linkedPosts', $data); ?>

        <?php endif; ?>
    <?php endif; ?>
</div>


<?php $render('partial/footer', $data); ?>