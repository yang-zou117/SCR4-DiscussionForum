<?php $render('partial/header', $data); ?>

<h1 class="mb-4">Open New Discussion</h1>

<div class="col-md-7">

<?php if(isset($data['errors'])) {
    $render('partial/errors', $data['errors']);
} ?>

<?php $beginForm('Discussions', 'NewDiscussion', method: 'post'); ?>
  <div class="form-group mb-4">
    <label for="topicTitle">Title:</label>
    <input type="text" class="form-control" id="topicTitle" name="topicTitle" 
            placeholder="Enter the title of the new topic">
  </div>
  <div class="form-group mb-3">
    <label for="postContent">First post to this topic:</label>
    <textarea class="form-control" id="postContent" name="postContent" rows="5" 
              placeholder="Enter the content of the first post"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Open Discussion</button>
<?php $endForm(); ?>
</div>

<?php $render('partial/footer', $data); ?>