<?php
include 'inc/header.php';
Session::CheckSession();
$sId = Session::get('roleid');

if ($sId === '1') {
    ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {
        // Verify reCAPTCHA
        $recaptchaSecretKey = 'YOUR_RECAPTCHA_SECRET_KEY';
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        $recaptchaVerification = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecretKey}&response={$recaptchaResponse}");
        $recaptchaData = json_decode($recaptchaVerification);

        if ($recaptchaData->success) {
            // CAPTCHA verification successful
            $userAdd = $users->addNewUserByAdmin($_POST);
        } else {
            // CAPTCHA verification failed
            $userAdd = "CAPTCHA verification failed. Please try again.";
        }
    }

    if (isset($userAdd)) {
        echo $userAdd;
    }
    ?>


    <div class="card ">
        <div class="card-header">
            <h3 class='text-center'>Add New User</h3>
        </div>
        <div class="cad-body">
            <div style="width:600px; margin:0px auto">
                <form class="" action="" method="post">
                    <div class="form-group pt-3">
                        <label for="name">Your name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="username">Your username</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="sel1">Select user Role</label>
                            <select class="form-control" name="roleid" id="roleid">
                                <option value="1">Admin</option>
                                <option value="2">Editor</option>
                                <option value="3">User only</option>
                            </select>
                        </div>
                    </div>

                    <!-- Google reCAPTCHA -->
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="addUser" class="btn btn-success">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
} else {
    header('Location:index.php');
}
?>

<?php
include 'inc/footer.php';
?>
