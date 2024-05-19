<?php
if (isset($_SESSION['uid'])) {
  header('Location:index.php');
}
require_once("utils/User.php");
$response = true;
if (isset($_POST['login'])) {
  $user = new User();
  $response = $user->login(
    ($_POST['type'] ?? null) === "tailor" ? "tailor" : (($_POST['type'] ?? null) === "admin" ? "admin" : "guest"),
    $_POST
  );
  if ($response === true && strtolower($_POST['type'] ?? null) === 'admin') {
    header('location:admin/dashboard.php');
  } elseif ($response === true && strtolower($_POST['type'] ?? null) === 'tailor') {
    header('location:tailor/tailor-dashboard.php');
  } elseif ($response === true) {
    header('Location:index.php');
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
  <title>Mending-Hems | Login</title>
</head>
<!-- <style>
    /* for debugging purpose */
    * {
      border: 1px solid red !important;
    }
  </style> -->

<body data-scroll-container class="font-roboto pattern-diagonal-lines-xl w-screen h-screen flex items-center justify-center text-stone-800 bg-stone-200">
  <div class="login shadow-lg w-11/12 md:w-10/12 lg:w-7/12 fl:w-8/12 rounded-md md:rounded-none md:rounded-l-md grid grid-cols-12 z-50">
    <div class="col-span-12 md:col-span-6 bg-white border rounded-md md:rounded-none md:rounded-l-md shadow-sm p-3">
      <div class="logo leading-tight font-raleway font-medium text-left uppercase tracking-widest">
        <p class="text-2xl font-semibold">Mending</p>
        <p class="text-[10px]">indian</p>
      </div>
      <!-- login form -->
      <form action="#" method="post" class="p-6 md:my-20 fl:my-32">
        <?php
        if ($response === 0) {
        ?>
          <label for="error" class="error mb-3 text-center text-sm text-orange-600">
            <p class="mb-2">account activation pending</p>
          </label>
        <?php
        }
        ?>
        <?php
        if ($response === false) {
        ?>
          <label for="error" class="error mb-3 text-center text-sm text-rose-600">
            <p class="mb-2">username/password are incorrect</p>
          </label>
        <?php
        }
        ?>
        <label for="type">
          <select name="type" class="rounded-md border border-stone-300 shadow-sm p-3 w-full">
            <option value="user">user</option>
            <option value="tailor">tailor</option>
            <option value="admin">admin</option>
          </select>
        </label>
        <label for="email">
          <input type="email" name="email" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Email" required />
        </label>
        <label for="password">
          <input type="password" name="password" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Password" min="8" required />
        </label>
        <label for="submit">
          <input type="submit" name="login" class="bg-stone-800 rounded-md text-white p-3 w-full mt-3" value="Login" />
        </label>
        <div class="mt-3 flex items-right justify-center">
          <p>forgot your password ?</p>
          <a href="reset.php" class="ml-1 font-medium underline underline-offset-1">
            <p>reset here</p>
          </a>
        </div>
        <div class="mt-2 flex items-center">
          <p>don't have an account</p>
          <a href="register.php" class="ml-1 font-medium underline underline-offset-1">
            <p>register here</p>
          </a>
        </div>
      </form>
    </div>
    <div class="hidden md:flex col-span-12 md:col-span-6 rounded-r-md bg-cover bg-left bg-no-repeat items-center justify-center" style="background-image: url(images/s6.png);">
      <div class="glass p-3 m-3 text-white">
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