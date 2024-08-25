<div class="signup bg-dark overflo-y-hodden">
        <div class="col-4 bg-dark border rounded p-4 shadow-sm">
<form method="post" action="./assets/php/actions.php?signup" class="row g-3">    
    <div class="d-flex justify-content-center">
    <img src="./assets/images/logo.png" class="mv-5"alt="" height="45">
    </div>
    <h3 class="text-white">Create your account</h3>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" value="<?= getPreviousFormData('first_name')?>" name="first_name" class="form-control" id="floatingInput" placeholder="Kosei">
            <label for="floatingInput">First Name</label>
        </div>
        <?=showError('first_name') ?>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text"  name="last_name" value="<?= getPreviousFormData('last_name')?>"class="form-control" id="floatingInput" placeholder="Arima">
            <label for="floatingInput">Last Name</label>
        </div>
        <?=showError('last_name') ?>
    </div>
    <div class="col-12 d-flex justify-content-flexs-start">
    <div class="form-check mx-3">
        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="1" <?=  getPreviousFormData('gender')==1?'checked': '' ?> <?= isset($_SESSION['formdata'])?'':'checked'?> >
        <label class="form-check-label text-white" for="flexRadioDefault1">
            male
        </label>
        </div>

        <div class="form-check mx-3">
        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="2" <?=  getPreviousFormData('gender')==2?'checked': '' ?>  >
        <label class="form-check-label text-white" for="flexRadioDefault2">
            Female
        </label>
        </div>
        <div class="form-check mx-3">
        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="0" <?=  getPreviousFormData('gender')==0?'checked': '' ?> >
        <label class="form-check-label text-white" for="flexRadioDefault2">
            Other
        </label>
        </div>

        </div>
        <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" value="<?= getPreviousFormData('username')?>"name="username" id="floatingInputGroup1" placeholder="Username">
                    <label for="floatingInputGroup1">Username</label>
                </div>
            <?=showError('username') ?>
        </div>
        <div class="col-12">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" value="<?= getPreviousFormData('email')?>" id="floatingInput" name="email" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <?=showError('email') ?>
        </div>
        <div class="col-12">
            <div class="form-floating mb-3">
                <input type="Password" class="form-control" id="floatingInput" name="password" placeholder="must be 8 digit">
                <label for="floatingInput">Password</label>
            </div>
            <?=showError('password') ?>
        </div>
        <div class="col-6">
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
            <div class="col-6">
            <a href="?login" class="ms-auto"> Already have an account Login</a>
        </div>
        </form>
    </div>
</div>