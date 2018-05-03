<?php
session_start();

include '../../services/connection.php';

include '../../services/userService.php';
$userService = new UserService($conn);

$userNameErrorMessage = "";
$passwordErrorMessage = "";
$loginErrorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $userName = $_POST["userName"];
    $password = $_POST["password"];

    if (empty($userName) || empty($password)) {
        $userNameErrorMessage = "Vui lòng nhập tên tài khoản";
        $passwordErrorMessage = "Vui lòng nhập tên mật khẩu";
    } else {
        if ($userService->login($userName, $password)) {
            header("Location: ../admin/index.php");
        }
        else
            $loginErrorMessage = "Tên tài khoản hoặc mật khẩu không chính xác";
    }
}

include '../admin/templates/head.php';

?>

<div class="card card-login mx-auto mt-5">
    <div class="card-header">Đăng nhập</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Tên đăng nhập</label>
                <input class="form-control" name="userName" type="text" aria-describedby="emailHelp"
                       placeholder="Tên đăng nhập" autofocus>
                <span class="text-danger"><?php echo $userNameErrorMessage ?></span>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Mật khẩu</label>
                <input class="form-control" name="password" type="password" placeholder="Mật khẩu">
                <span class="text-danger"><?php echo $passwordErrorMessage ?></span>
            </div>
            <div>
                <span class="text-danger"><?php echo $loginErrorMessage ?></span>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        </form>
    </div>
</div>

