<div class="col text-end">
  <?php if (!isset($data['user'])): ?>
    <nav class="navbar-nav">
      <div class="col login-navlink">
        <?php $link('Login', 'User', 'LogIn', cssClass: 'nav-link ' . ($data['active'] == 'LoginSignUp' ? 'active-link': '')); ?>
      </div>
    </nav>
  <?php else: ?>
    <?php $beginForm('User', 'LogOut', method: 'post', cssClass: 'form-inline'); ?>
      <span class="navbar-text me-2">Logged in as <strong><?php $htmlOut($data['user']->userName); ?></strong></span>
      <button class="btn btn-outline-danger">Log out &nbsp;<i class="bi bi-box-arrow-right"></i></button>
    <?php $endForm(); ?>
  <?php endif; ?>
</div>