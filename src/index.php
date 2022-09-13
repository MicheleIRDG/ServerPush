<?php
session_start();
$error = '';
if(isset($_SESSION['userid'])) header('location:../chatroom.php');

if(isset($_POST['login'])) {
    require_once('../class/ChatUser.php');

    $user_object = new ChatUser;
    $user_object->setUserEmail($_POST['user_email']);
    $user_data = $user_object->get_user_data_by_email();

    if(is_array($user_data) && count($user_data) > 0) {
        if($user_data['user_status'] == 'Enable') {
            if($user_data['user_password'] === $_POST['user_password']) {
                $user_object->setUserId($user_data['user_id']);
                $user_object->setUserLoginStatus('Login');
	            $user_token = substr(sha1(time()), 0, 128);
	            $user_object->setUserToken($user_token);

                if($user_object->update_user_login_data()) {
                    $_SESSION['userid'] = $user_data['user_id'];
                    $_SESSION['name'] = $user_data['user_name'];
                    $_SESSION['profile'] = $user_data['user_profile'];
                    $_SESSION['token'] = $user_token;

                    header('location:chatroom.php');
                } // fine if
            } else {
                $error = 'Wrong Password';
            } // fine if
        } else {
            $error = 'Please Verify Your Email Address';
        } // fine if
    } else {
        $error = 'Wrong Email Address';
    } // fine if
} // fine if
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login | PHP Chat Application using Websocket</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
<div class="containter">
    <br />
    <br />
    <h1 class="text-center">Chat Application in PHP & MySql using WebSocket - Login</h1>
    <div class="row justify-content-md-center mt-5">
        <div class="col-md-4">
            <?php if(isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-success">
                    '.$_SESSION["success_message"] .'
                    </div>';
                unset($_SESSION['success_message']);
            } // fine if

            if($error != '') {
                echo ' <div class="alert alert-danger">
                    '.$error.'
                    </div>';
            } // fine if ?>
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post" id="login_form">
                        <div class="form-group">
                            <label>Enter Your Email Address</label>
                            <input type="text" name="user_email" id="user_email"  class="form-control" data-parsley-type="email" required />
                        </div>
                        <div class="form-group">
                            <label>Enter Your Password</label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required />
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" name="login" id="login" class="btn btn-primary" value="Login" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
