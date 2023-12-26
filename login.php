<?php
include 'inc/header.php';
Session::CheckLogin();
?>

<?php
$iLoginType = $_GET['loginType'];
$sLoginType = ($iLoginType == 1) ? "Admin" : "User";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $your_database_connection->prepare("SELECT * FROM your_users_table WHERE email = ? AND password = ? AND login_type = ?");
    $stmt->bind_param("sss", $email, $password, $iLoginType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User authentication successful
        $userLog = "Login successful";
    } else {
        // Invalid login credentials
        $userLog = "Invalid login credentials";
    }

    $stmt->close();
}

if (isset($userLog)) {
    echo $userLog;
}

$logout = Session::get('logout');
if (isset($logout)) {
    echo $logout;
}
?>

<div class="card ">
    <div class="card-header">
        <center><h3><b>Secure Web Development CA2</b></h3></center>
        <h3 class='text-center'><i class="fas fa-sign-in-alt mr-2"></i><?php echo $sLoginType; ?> login</h3>
    </div>
    <div class="card-body">
        <div style="width:450px; margin:0px auto">
            <form class="" action="" method="post">
                <input type="hidden" name="loginType" value="<?php echo $iLoginType; ?>" class="form-control">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" name="login" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'inc/footer.php';
?>
