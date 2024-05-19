<?php
session_start();
if (!isset($_SESSION['uid'])) {
  header('Location:login.php');
}
$pid = (int) $_GET['id'] ?? null;
if (is_null($pid) || $pid <= 0)
  header('Location:index.php');

require_once("utils/Db.php");
$db = Db::getInstance();
// if add to cart clicked
if (isset($_POST['addToCart'])) {
  $product_id = $pid;
  $quantity = 1;
  $size = $_POST['size'] ?? null;
  $user_id = $_SESSION['uid'];
  $query = "SELECT quantity FROM cart WHERE product_id = $product_id AND user_id = $user_id";
  $result = $db->query($query);
  if ($result->num_rows > 0) {
    $query = "UPDATE cart SET quantity = quantity + $quantity, variant = CONCAT(variant, ',', '$size') WHERE product_id = $product_id AND user_id = $user_id";
  } else {
    $query = "INSERT INTO cart (product_id, quantity, user_id, variant) VALUES ('$product_id', '$quantity', '$user_id', '$size')";
  }
  $db->query($query);
}
if (isset($_POST['buy-1'])) {
  $product_id = $pid;
  $quantity = 1;
  $user_id = $_SESSION['uid'];
  $query = "SELECT quantity FROM cart WHERE product_id = $product_id AND user_id = $user_id";
  $profile = json_encode($db->query("SELECT profile_data FROM profiles WHERE id='{$_POST['profiles']}'")->fetch_assoc());
  $result = $db->query($query);
  if ($result->num_rows > 0) {
    if (isset($_POST['submit_fabrics']) && $_POST['submit_fabrics'] === 'on') {
      $query = "UPDATE cart SET submit_fabrics = 1, quantity = quantity + $quantity, profile = CONCAT(profile, '|', '$profile') WHERE product_id = $product_id AND user_id = $user_id";
    } else {
      $query = "UPDATE cart SET quantity = quantity + $quantity, profile = CONCAT(profile, '|', '$profile') WHERE product_id = $product_id AND user_id = $user_id";
    }
  } else {
    if ($_POST['submit_fabrics'] === 'on') {
      $query = "INSERT INTO cart (product_id, quantity, user_id, submit_fabrics, profile) VALUES ('$product_id', '$quantity', '$user_id', '1', '$profile')";
    } else {
      $query = "INSERT INTO cart (product_id, quantity, user_id, submit_fabrics, profile) VALUES ('$product_id', '$quantity', '$user_id', '0', '$profile')";
    }
  }
  $db->query($query);
}
// fetch and display product
$query = "SELECT products.*, users.username as username FROM products INNER JOIN users ON products.publisher = users.id WHERE products.id = $pid";
$result = $db->query($query);
if ($result->num_rows <= 0)
  header('Location:index.php');
$product = $row = $result->fetch_assoc();
$product['images'] = explode(",", $product['images']);
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
  <title>Mending-Hems | Product</title>
</head>
<!-- <style>
        /* for debugging purpose */
        * {
          border: 1px solid red !important;
        }
      </style> -->

<body data-scroll-container class="font-roboto">
  <!-- nav -->
  <?php include_once "nav.php" ?>
  <div class="product grid grid-cols-12 gap-2">
    <div class="col-span-12 md:col-span-7 grid grid-cols-12">
      <div class="col-span-3">
        <?php
        for ($i = 1; $i < count($product['images']); $i++) {
        ?>
          <img src="<?php echo $product['images'][$i] ?>" alt="" />
        <?php
        }
        ?>
      </div>
      <div class="col-span-9">
        <img src="<?php echo $product['images'][0] ?>" alt="" class="w-full" />
      </div>
    </div>
    <div class="col-span-12 md:col-span-5 p-3">
      <div class="titles">
        <p class="font-medium font-raleway text-2xl py-3">
          <?php echo $product['name'] ?>
        </p>
        <p class="font-raleway text-xs">
          CRAFTED BY
          <b><?php echo $product['username'] ?></b>
        </p>
        <p class="price"><?php echo $product['price'] ?> ₹</p>
      </div>
      <div class="buy py-3 flex flex-col">
        <form action="#" method="post" class="w-full buy-form">
          <div class="sizes flex justify-center md:justify-start mb-3">
            <?php
            $count = count(explode(',', $product['sizes'])) - 1;
            $itr = $count;
            foreach (explode(',', $product['sizes']) as $size) {
            ?>
              <div class="size hover:bg-rose-700 cursor-pointer bg-rose-600 text-white p-3 <?php echo $itr === 0 ? 'rounded-r-md' : ($itr === $count ? 'rounded-l-md' : '') ?> text-sm">
                <p><?php echo $size ?></p>
              </div>
            <?php
              $itr--;
            }
            ?>
            <input type="hidden" name="size" value="<?php echo explode(',', $product['sizes'])[0] ?? 'MD' ?>">
          </div>
          <button name="addToCart" class="btn w-full rounded-md cursor-pointer text-center shadow-md bg-stone-800 text-white p-3">
            Buy now
          </button>
        </form>
        <div class="flex mt-2">
          <form action="#" class="w-1/2" method="post">
            <div class="w-full flex">
              <button name="addToCart" class="btn grow text-center mr-2 rounded-md cursor-pointer hover:bg-stone-800 hover:text-white border border-stone-800 p-2.5">
                <i class="ri-shopping-cart-2-fill text-xl"></i>
                <p>Add to cart</p>
              </button>
            </div>
          </form>
          <div class="btn grow fit-size text-center rounded-md cursor-pointer bg-rose-600 text-white p-3">
            <i class="ri-shirt-fill text-xl"></i>
            <p>Fit Size</p>
          </div>
        </div>
        <!-- fit size modal popup -->
        <div class="bg-stone-800/25 hidden backdrop-fit-size cursor-pointer w-screen h-screen p-3 flex items-center justify-center fixed top-0 left-0 right-0 bottom-0">
          <div class="bg-white capitalize cursor-default w-11/12 md:w-7/12 lg:w-5/12 p-3 rounded-md">
            <?php
            $res = $db->query("SELECT * FROM profiles WHERE user_id='{$_SESSION['uid']}'");
            if ($res->num_rows >= 1) {
            ?>
              <p class="text-stone-600 text-sm mb-2">Available profiles</p>
              <form action="#" method="post">
                <select name="profiles" class="rounded-md border border-stone-300 shadow-sm p-3 w-full">
                  <?php
                  while ($row = $res->fetch_assoc()) {
                  ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['profile_name'] ?></option>
                  <?php
                  }
                  ?>
                </select>
                <div class="flex items-center">
                  <p class="text-sm text-rose-700 mr-2 mt-2">Submit your Own Fabrics</p>
                  <input type="checkbox" name="submit_fabrics" id="">
                </div>
                <div class="note flex bg-rose-300/50 rounded-md p-3 mt-2 mb-1 text-rose-700">
                  <i class="ri-error-warning-line text-3xl mr-2"></i>
                  <p class="text-sm font-semibold">this vendor also accepts fabrics , but it's your responsiblity to submit it on time at their location.</p>
                </div>
                <div class="mt-2 flex items-center">
                  <input type="submit" name="buy-1" class="w-full mr-1 bg-stone-800 p-3 rounded-md text-white" value="Add to cart">
                  <a href="profiler.php" class="w-full text-center ml-1 bg-rose-800 p-3 rounded-md text-white">make another profile</a>
                </div>
              </form>
            <?php
            } else {
            ?>
              <p>no profiles found , <a href="profiler.php" class="text-rose-500 underline">get a new one</a></p>
            <?php
            }
            ?>
          </div>
        </div>
        <?php
        $isCustomizationAvailable = $db->query("SELECT products.id FROM products INNER JOIN customize ON products.id = customize.product_id WHERE products.id = $pid")->num_rows >= 1;
        if ($isCustomizationAvailable) {
        ?>
          <a href="customize.php?pid=<?php echo $pid ?>">
            <div class="btn w-1/2 mt-2 flex items-center rounded-md cursor-pointer bg-rose-600 text-white p-3">
              <i class="ri-settings-line text-3xl"></i>
              <p class="ml-2">Customize</p>
            </div>
          </a>
        <?php
        }
        ?>
      </div>
      <!-- accordians -->
      <div class="details ">
        <div class="accordian">
          <div class="accordian-title flex">
            <p class="grow">Details</p>
            <i class="ri-add-circle-fill"></i>
          </div>
          <div class="accordian-content">
            <p>
              Material
              <span class="font-medium">100% wool</span>
            </p>
            <p>
              Tailored By
              <span class="font-medium">Cool Tailors</span>
            </p>
            <p>
              Season
              <span class="font-medium">All seasons</span>
            </p>
          </div>
        </div>
        <div class="accordian">
          <div class="accordian-title flex">
            <p class="grow">Description</p>
            <i class="ri-add-circle-fill"></i>
          </div>
          <div class="accordian-content">
            <p>
              Infused with an elegant and refined style, this optical white
              satin suit is ideal as a tuxedo or as part of a ceremony look
              thanks to its refined and suave allure.
            </p>
          </div>
        </div>
        <div class="accordian">
          <div class="accordian-title flex">
            <p class="grow">Palazzos design</p>
            <i class="ri-add-circle-fill"></i>
          </div>
          <div class="accordian-content">
            <p>
              Embroidered Palazzos, Partially elasticated waistband ,2 pockets
              Slip-on closure
            </p>
          </div>
        </div>
        <div class="accordian">
          <div class="accordian-title flex">
            <p class="grow">Size & Fit</p>
            <i class="ri-add-circle-fill"></i>
          </div>
          <div class="accordian-content">
            <ul>
              <li>Size worn by the model: S</li>
              <li>Chest: 31"</li>
              <li>Waist: 24"</li>
              <li>Hips: 38''</li>
              <li>Height: 5'8"</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- footer -->
  <?php include_once "footer.php" ?>
</body>
<script>
  document.querySelectorAll('.size').forEach((el) => {
    el.addEventListener('click', () => {
      document.querySelector('input[name="size"]').value = el.innerText
      document.querySelectorAll('.size').forEach((el2) => {
        if (el2 === el)
          el2.classList.add('bg-rose-700')
        else
          el2.classList.remove('bg-rose-700')
      })
    })
  })
  // open backdrop
  let backDrop = document.querySelector('.backdrop-fit-size')
  document.querySelector('.backdrop-fit-size')
  backDrop.addEventListener("click", function(e) {
    if (e.target !== this)
      return
    this.classList.toggle('hidden')
  })
  document.querySelector(".fit-size").addEventListener('click', function() {
    backDrop.classList.toggle('hidden')
  })
</script>

</html>