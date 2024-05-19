<?php
if (isset($_SESSION['uid'])) {
    header('Location:index.php');
}
require_once("utils/User.php");
$tokenExists = false;
$token = null;
if (isset($_GET['token'])) {
    include_once("utils/Db.php");
    $db = Db::getInstance();
    $res = $db->query("SELECT * FROM activate WHERE token = '{$_GET['token']}'");
    if ($res->num_rows === 1) {
        $tokenExists = true;
        $token = $_GET['token'];
    }
}
if (isset($_POST['resetPassword'])) {
    $password = $_POST['password'];
    if ($tokenExists) {
        $uId = $res->fetch_assoc()['user_id'];
        $db->query("UPDATE users SET password = '$password' WHERE id = $uId");
        $db->query("DELETE FROM activate WHERE token = '$token'");
        header('Location:login.php');
    }
}
$response = true;
if (isset($_POST['reset'])) {
    $user = new User();
    $response = $user->resetPassword($_POST['email'] ?? null);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="dist/output.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,400;1,700&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/pattern.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js" integrity="sha512-f8mwTB+Bs8a5c46DEm7HQLcJuHMBaH/UFlcgyetMqqkvTcYg4g5VXsYR71b3qC82lZytjNYvBj2pf0VekA9/FQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="js/anim.js" defer></script>
    <title>Mending-Hems | Login</title>
</head>
<!-- <style>
    /* for debugging purpose */
    * {
      border: 1px solid red !important;
    }
  </style> -->

<body data-scroll-container class="font-roboto pattern-diagonal-lines-xl w-screen h-screen flex items-center justify-center text-stone-800 bg-stone-200">
    <div class="login shadow-lg w-11/12 md:w-5/12 lg:w-3/12 fl:w-3/12 rounded-md md:rounded-none md:rounded-l-md z-50">
        <div class="w-full bg-white border rounded-md shadow-sm p-3">
            <div class="logo leading-tight mb-3 font-raleway font-medium text-left uppercase tracking-widest">
                <p class="text-2xl font-semibold">PWNIERO</p>
                <p class="text-[10px]">indian</p>
            </div>
            <!-- login form -->
            <?php
            if ($tokenExists) {
            ?>
                <form action="#" method="post" class="">
                    <label for="password">
                        <input type="password" name="password" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Password" required />
                    </label>
                    <label for="submit">
                        <input type="submit" name="resetPassword" class="bg-stone-800 rounded-md text-white p-3 w-full mt-3" value="Change" />
                    </label>
                </form>
            <?php
            } else {
            ?>
                <form action="#" method="post" class="">
                    <?php
                    if ($response === false) {
                    ?>
                        <label for="error" class="error mb-3 text-center text-sm text-rose-600">
                            <p class="mb-2">email is incorrect</p>
                        </label>
                    <?php
                    }
                    ?>
                    <label for="email">
                        <input type="email" name="email" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Email" required />
                    </label>
                    <label for="submit">
                        <input type="submit" name="reset" class="bg-stone-800 rounded-md text-white p-3 w-full mt-3" value="Reset" />
                    </label>
                </form>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>