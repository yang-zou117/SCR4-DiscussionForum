<!-- posts  -->
<div class="mt-4">
    <p class="lead"><b>Posts: </b></p>
    <?php foreach ($data['posts'] as $post) : ?>
        <div class="card mb-3 post-card" 
        <?php $pid = $data['scrollToPost'] ?? null;
            if(isset($pid) && !empty($pid) && $pid == $post->id) 
            { $htmlOut("id=scrollToPost");}?>>
            <div class="card-header">
                <?php $htmlOut('By ') ?>
                <b><?php $htmlOut($post->author) ?></b>
                <?php $htmlOut(' on ') ?>
                <?php $htmlOut($post->createdAt) ?>
            </div>
            <div class="card-body">
                <p class="card-text"><?php $htmlOut($post->content) ?></p>
            </div>
        </div>
    <?php endforeach; ?>

</div>


<!-- scroll to post if user has searched for a post -->
<script>
    document.getElementById('scrollToPost').scrollIntoView();
    document.getElementById('scrollToPost').classList.add('border-warning');    
</script>


