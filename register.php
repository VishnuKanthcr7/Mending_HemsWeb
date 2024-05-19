<?php
session_start();
if (isset($_SESSION['uid'])) {
    header('Location:index.php');
}
require_once("utils/User.php");
if (isset($_POST['register'])) {
    $user = new User();
    $response = $user->register(($_POST['type'] ?? null) === "tailor" ? "tailor" : "guest", $_POST);
    if ($response === true) {
        header('Location:login.php');
    }
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
    <title>Mending-Hems | Register</title>
</head>
<!-- <style>
    /* for debugging purpose */
    * {
      border: 1px solid red !important;
    }
  </style> -->

<body data-scroll-container class="font-roboto pattern-diagonal-lines-xl w-screen h-screen flex items-center justify-center text-stone-800 bg-stone-200">
    <div class="login shadow-lg w-11/12 md:w-10/12 lg:w-7/12 fl:w-8/12 rounded-md md:rounded-none md:rounded-l-md grid grid-cols-12 z-50">
        <div class="col-span-12 md:col-span-6 bg-white rounded-md md:rounded-none md:rounded-l-md border shadow-sm p-3">
            <div class="logo leading-tight font-raleway font-medium text-left uppercase tracking-widest">
                <p class="text-2xl font-semibold">Mending</p>
                <p class="text-[10px]">indian</p>
            </div>
            <!-- login form -->
            <form action="#" method="post" class="p-6 md:my-12 fl:my-24">
                <label for="type">
                    <select name="type" class="rounded-md border border-stone-300 shadow-sm p-3 w-full" required>
                        <option value="user">user</option>
                        <option value="tailor">tailor</option>
                    </select>
                </label>
                <label for="userName">
                    <input type="text" name="userName" class="border <?php echo ($response["userName"] ?? null) ? 'border-rose-600' : 'border-stone-300' ?> rounded-md border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="username" required />
                    <?php echo ($response["userName"] ?? null) ? '<p class="text-xs text-rose-600">* username is already taken</p>' : '' ?>
                </label>
                <label for="email">
                    <input type="email" name="email" class="border <?php echo ($response["email"] ?? null) ? 'border-rose-600' : 'border-stone-300' ?> rounded-md border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Email" required />
                    <?php echo ($response["email"] ?? null) ? '<p class="text-xs text-rose-600">* email is already taken</p>' : '' ?>
                </label>
                <label for="phone">
                    <input type="number" name="phone" class="border <?php echo ($response["phone"] ?? null) ? 'border-rose-600' : 'border-stone-300' ?> rounded-md border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Phone Number" required />
                    <?php echo ($response["phone"] ?? null) ? '<p class="text-xs text-rose-600">* phone is already taken</p>' : '' ?>
                </label>
                <label for="password">
                    <input type="password" name="password" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Password" min="8" required />
                </label>
                <label for="submit">
                    <input type="submit" name="register" class="rounded-md border border-stone-300 text-white bg-stone-800 shadow-sm p-3 w-full mt-3" value="Register" />
                </label>
                <div class="mt-3 flex items-center">
                    <p>have an account</p>
                    <a href="login.php" class="ml-1 font-medium underline underline-offset-1">
                        <p>login here</p>
                    </a>
                </div>
            </form>
        </div>
        <div class="hidden rounded-r-md md:flex col-span-12 md:col-span-6 bg-cover bg-top bg-no-repeat items-center justify-center" style="background-image: url(images/s7.png);">
            <div class="glass rounded-md p-3 m-3 text-white">
                <p>
                    Fashion Basket Red & Pink Embroidered Semi-Stitched Lehenga &
                    Unstitched Blouse With Dupatta
                </p>
                <p class="text-2xl font-medium">₹ 2,999</p>
            </div>
        </div>
    </div>
</body>

</html>