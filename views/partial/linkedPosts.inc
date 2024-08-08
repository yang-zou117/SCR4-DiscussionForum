<div class="mt-4">
    <?php foreach ($data['posts'] as $post) : ?>
        <div class="card mb-3 post-card">
        <div class="card-header" style="line-height: 1.8;">
        <div class="row">
            <div class="col-10">
                <?php $htmlOut('(Topic: ') ?>
                <b><?php $link($post->topic, 'Posts', 'PostsOfDiscussion', 
                        ['did' => $post->discussionId, 'scrollToPost' => $post->id], 
                        cssClass: 'topic-link'); ?>  </b>
                <?php $htmlOut(')'); ?>
                <br>
                <?php $htmlOut('By '); ?>
                <b><?php $htmlOut($post->author); ?></b>
                <?php $htmlOut(' on '); ?>
                <?php $htmlOut($post->createdAt); ?>
            </div>

            <div class="col-2">
                <!-- provide remove button if posts are from the same user -->
                <?php if (isset($data['postsOfOneUser'])) { ?>
                    <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-outline-danger mr-2" type="button" 
                            onclick="toggleDeleteButton(<?php $htmlOut($post->id)?>)" 
                            id="<?php $htmlOut($post->id)?>deleteButton">
                        <i class="bi bi-trash"></i>
                    </button>&nbsp;&nbsp;
                    <?php $beginForm('Posts', 'DeletePost', [
                        'did' => $post->discussionId, 'pid' => $post->id], 
                        'post', cssClass: 'form-inline'); ?>
                        <button class="btn btn-outline-danger" type="submit"
                                id="<?php $htmlOut($post->id)?>deleteButtonConfirm" 
                                style="display:none">
                            <i class="bi bi-check"></i>
                        </button>
                    <?php $endForm(); ?>
                    </div>
                <?php } ?>
                
            </div>
            </div>
        </div>

        <div class="card-body">
            <p class="card-text"><?php $htmlOut($post->content) ?></p>
        </div>
        </div>
    <?php endforeach; ?>
</div>