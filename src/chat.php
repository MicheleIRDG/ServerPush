<?php
session_start();
if(!isset($_SESSION)) header('location:../index.php');

require('../class/ChatUser.php');
require('../class/ChatRooms.php');

$chat_object = new ChatRooms;
$chat_data = $chat_object->get_all_chat_data();
$user_object = new ChatUser;
$user_data = $user_object->get_user_all_data();
include "modal_add_user.php";

//print_r($_SESSION);
$token = $_SESSION['token'];
?>

<!doctype html>
<html lang="en">
<head>
	<title>Real time chat  in php using web socket</title>

    <meta name="Description" content="Aksilia Suite is a software made by Aksilia to make assessments and audits about a regulation.">

	<!-- Bootstrap core CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Bootstrap core JavaScript -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<!-- Core plugin JavaScript-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- Bootstrap select-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

    <!-- viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable:no" />
    <!--og:meta-->
    <meta property=og:locale content=en_US>
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" style="height: 60px;">
	<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Header Aksiliasuite</a>
	<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="navbar-nav">
		<div class="nav-item text-nowrap">
			<a class="nav-link px-3" href="#">Sign out</a>
		</div>
	</div>
</header>

<div class="container-fluid d-inline-flex p-0">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="padding: 0 10px 0 0; height: 90vh;">
        <div class="position-sticky pt-3">
            <div class="d-inline-flex w-100">
                <input class="form-control form-control-dark" style="margin: 0 10px 0 15px" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary" id="create_room" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus"></i></button>
            </div>
            <hr class="mb-2">
            <ul class="nav flex-column">
                <?php foreach($user_data as $key => $user) {
                    echo '<li class="nav-item">
                            <a class="nav-link active pl-0" aria-current="page" href="#">
                                <img src="gdpr.png" class="img-fluid rounded-circle img-thumbnail" width="32"/>&nbsp;
                                <span class="ml-1"><strong>'.$user['user_name'].'</strong></span>&nbsp;
                                <span class="mt-2 float-end"><i class="fa fa-circle text-success"></i></span>
                            </a>
                        </li>';
                } // fine foreach ?>
            </ul>
        </div>
    </nav>
    <main role="main" class="w-100" style="padding: 0 0 0 10px !important;">
        <?php include "chatroom.php"; ?>
    </main>
</div>
</body>
</html>
