<?php $render('partial/header', $data); ?>

<div class="mt-5">
    <p class="lead"><b>Selected Topic: </b></p>
    <h2><?php $htmlOut($data['selectedTopic']) ?></h2>
    
    <!-- error or success for adding new post -->
    <div class="col-md-7">
    <?php if(isset($data['errors'])) {
        $render('partial/errors', $data['errors']);
        } ?>
    <?php if(isset($data['addPostSuccess'])) { ?>
        <div class="alert alert-success">
            <p>New Post added successfully</p>
        </div>
    <?php } ?>
    </div>

    <!-- add new post form -->
    <button type="button" class="btn btn-secondary mt-3" data-bs-toggle="collapse" 
            data-bs-target="#new-post-form">
        <i class="bi bi-plus"></i>
        Add Post
    </button>
    <div class="col-md-7">
    <?php $beginForm('Posts', 'AddNewPost', ['did' => $data['did']], method:'post'); ?>
        <div id="new-post-form" class="collapse form-group mt-3">
            <textarea class="form-control" id="postContent" name="postContent" rows="5" 
            placeholder="Enter the content of the your post"></textarea>
            <button type="submit" class="btn btn-primary mt-3">
                <i class="bi bi-send"></i>
                Submit 
            </button>
        </div>
    <?php $endForm(); ?>
    </div>

</div>

<hr class="border border-primary border-1 opacity-10">


<?php $render('partial/posts', $data); ?>
<?php $render('partial/footer', $data); ?>