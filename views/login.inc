<?php $render('partial/header', $data); ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-7">
            <!-- error or success -->
            <?php if(isset($data['errors'])) {
                $render('partial/errors', $data['errors']);
             } ?>
            <?php if(isset($data['registerSuccess'])) { ?>
                <div class="alert alert-success">
                    <p>Registration successful. Please login.</p>
                </div>
            <?php } ?>
            
        <div class="card">
            <div class="card-header">
            <h2 class="text-center">Login to your account</h2>
            </div>
            <div class="card-body">
            <?php $beginForm('User', 'LogIn', method: 'post'); ?>
                <div class="mb-3">
                    <label for="userName" class="form-label">User name</label>
                    <input class="form-control" id="userName" name="un" 
                            value="<?php $htmlOut($data['userName']); ?>">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="pwd">
                </div>
                <div class="text-center text-lg-start mt-3 pt-2">
                    <button class="btn btn-primary w-100">Login</button>
                    <p class="small fw-bold mt-3 pt-1 mb-0 text-center">Don't have an account? 
                    <?php $link('Register here', 'User', 'Register', cssClass: 'link-danger'); ?>
                    </p>
                </div>
                <?php $endForm(); ?>
            </div>
        </div>
    </div>
</div>

  
<?php $render('partial/footer', $data); ?>

