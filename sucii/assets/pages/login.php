    <div class="login bg-dark">
        <div class="col-4 bg-dark border rounded p-4 shadow-sm">
        <form method="post" action="./assets/php/actions.php?login">    
        <div class="d-flex justify-content-center">
        <img src="./assets/images/logo.png" alt="" height="45">
                </div>
                <h1 class="h5 mb-3 text-white fw-normal">Please sign in</h1>

                <div class="form-floating">
                    <input type="text" value="<?= getPreviousFormData('username_email')?>" name="username_email" class="form-control rounded-0" placeholder="username/email">
                    <label for="floatingInput">username/email</label>
                    <?= showError('username_email')?>
                </div>

                <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">password</label>
                </div>
                <?= showError('password')?>
                <?= showError('checkUserLoginData')?> 
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit">Login</button>
                    <a href="?signup" class="text-decoration-none">Create New Account</a>
                </div>
                <a href="?forgotPassword&newForgotPassword" class="text-decoration-none">Forgot password ?</a>
            </form>
        </div>
    </div>