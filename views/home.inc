<!-- welcome section -->
<?php $render('partial/header', $data); ?>
<h1>Welcome to our Discussion Forum</h1>
<hr class="border border-primary border-1 opacity-10 ">
<p>Our forum is a community of people who share a common interest. We welcome you to join and participate in our discussions.</p>

<!-- rules section -->
<div class="d-inline-flex mx-auto align-items-center">
    <p class="mt-3">Here are our community rules: &nbsp; &nbsp;</p>
    <button class="btn btn-outline-dark btn-sm ml-5" 
            data-bs-toggle="collapse" data-bs-target="#rulesList" 
            onclick="toggleCollapseButton()" id="collapseRulesListButton">
        <i class="bi bi-chevron-down"></i>
    </button>
</div>
<ul class="collapsed show" id="rulesList">
  <li>No insults or personal attacks allowed</li>
  <li>Respect others' opinions and beliefs</li>
  <li>Keep discussions on-topic and relevant</li>
  <li>No spamming or advertising</li>
  <li>Do not post illegal or inappropriate content</li>
  <li>Do not harass or bully other members</li>
</ul>

<hr class="border border-primary border-1 opacity-10">

<!-- dicussion section -->
<?php if ($data['discussions'] !== null): 
    if(sizeof($data['discussions']) > 0) { ?>
        <h2 class="mb-4">Current Discussions</h2>
        <?php $render('partial/discussions', ['discussions' => $data['discussions']]);
    } else { ?>
        <p>No discussions happening currently</p>
    <?php } ?>

<?php endif; ?>



<?php $render('partial/footer', $data); ?>