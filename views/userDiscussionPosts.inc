<?php $render('partial/header', $data); ?>

<?php if(isset($data['deletedSuccess'])): ?>
    <div class="alert alert-success">
        <p>Successfuly removed</p>
    </div>
<?php endif; ?>

<?php if(isset($data['errors'])) {
                $render('partial/errors', $data['errors']);
} ?>


<?php 
    if(isset($data['discussions'])) {
        if(sizeof($data['discussions']) > 0) { ?>
            <h2 class="mb-4">Your Discussions:</h2>
            <?php $render('partial/discussions', $data);
        } else { ?>
            <h2>You haven't started any discussions.</h2>
    <?php } 
    } else { ?>
        <h2>You are not logged in.</h2>
<?php } ?>

<hr class="border border-primary border-1 opacity-10 mt-5">

<?php if(isset($data['posts'])): ?>
    <?php if(sizeof($data['posts']) > 0) { ?>
        <h2 class="mb-4">Your Posts:</h2>
        <?php $render('partial/linkedPosts', $data); ?>
    <?php } else { ?>
        <h2>You haven't posted anything.</h2>
    <?php } ?>
<?php endif; ?>


<?php $render('partial/footer', $data); ?>