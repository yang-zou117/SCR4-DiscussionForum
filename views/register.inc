<?php $render('partial/header', $data); ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-7">
            <?php if(isset($data['errors'])) {
            $render('partial/errors', $data['errors']);
             } ?>
        <div class="card">
            <div class="card-header">
            <h2 class="text-center">Register new account</h2>
            </div>
            <div class="card-body">
            <?php $beginForm('User', 'Register', method: 'post'); ?>

                <div class="mb-3">
                    <label for="userName" class="form-label">Choose a user name</label>
                    <input class="form-control" id="userName" name="register_name" 
                        value="<?php if(isset($data['register_name'])) 
                        {$htmlOut($data['register_name']);}?>">
                </div>
                <div class="mb-4">
                    <label for="register_password" class="form-label">Choose a password</label>
                    <input type="password" class="form-control" id="register_password" 
                    name="register_pwd">
                </div>
                <div class="mb-4">
                    <label for="repeat_password" class="form-label">Repeat password</label>
                    <input type="password" class="form-control" id="repeat_password" 
                    name="repeat_pwd">
                </div>
                <!-- checkbox for agree terms -->
                <div class="mb-3 text-center">
                    <label for="registerCheck" class="form-label">I have read and agree to 
                        the terms and conditions &nbsp;</label>
                    <input type="checkbox" class="form-check-input" id="registerCheck" 
                    name="registerCheck">
                </div>

                <div class="text-center text-lg-start mt-3 pt-2">
                    <button class="btn btn-primary w-100">Register</button>
                </div>
                <?php $endForm(); ?>
            </div>
        </div>
    </div>
</div>

  
<?php $render('partial/footer', $data); ?>