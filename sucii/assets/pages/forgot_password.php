<div class="login">
    <div class="col-4 bg-dark border rounded p-4 shadow-sm">
        <?php
        if (isset($_SESSION['forgot_code']) && !isset($_SESSION['auth_temp'])) {
            $action = 'verifycode';
        } elseif (isset($_SESSION['forgot_code']) && isset($_SESSION['auth_temp'])) {
            $action = 'changepassword';
        } else {
            $action = 'forgotPassword';
        }
        ?>
        <form method="post" action="./assets/php/actions.php?<?= htmlspecialchars($action, ENT_QUOTES, 'UTF-8') ?>" class="row g-3">    
            <h1 class="text-white h5 mb-3 fw-normal">Forgot Your Password?</h1>

            <?php if ($action == 'forgotPassword') { ?>
                <p>Enter your valid mail address</p>
                <div class="form-floating">
                    <input type="email" name="email" class="form-control rounded-0" placeholder="username/email" >
                    <label for="floatingInput">Enter your email</label>
                </div>
                <?= showError('email') ?>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit">Send Verification Code</button>
                </div>
            <?php } ?>

            <?php if ($action == 'verifycode') { ?>
                <p>Enter 6 Digit Code Sent to - <?= htmlspecialchars($_SESSION['forgot_email'], ENT_QUOTES, 'UTF-8') ?></p>
                <div class="form-floating mt-1">
                    <input type="text" name="code" class="form-control rounded-0" id="floatingPassword" placeholder="######" >
                    <label for="floatingPassword">######</label>
                </div> 
                <?= showError('email_verify') ?>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit">Verify Code</button>
                </div>
            <?php } ?>

            <?php if ($action == 'changepassword') { ?>
                <p>Enter your new password</p>
                <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="New Password" >
                    <label for="floatingPassword">New Password</label>
                </div>
                <?= showError('password') ?>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit">Change Password</button>
                </div>
            <?php } ?>

            <br>
            <a href="?login" class="text-decoration-none mt-5"><i class="bi bi-arrow-left-circle-fill"></i> Go Back To Login</a>
        </form>
    </div>
</div>
