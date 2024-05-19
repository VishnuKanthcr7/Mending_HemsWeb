<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:login.php');
}
require_once("utils/Db.php");
$db = Db::getInstance();
// if got delete
if (isset($_GET['delete'])) {
    $db->query("DELETE FROM cart WHERE user_id = '{$_SESSION['uid']}' AND id = {$_GET['delete']}");
    header('Location:checkout.php');
}
// fetch current users's cart
$user_id = $_SESSION['uid'];
$query = "SELECT cart.variant, cart.variants, cart.submit_fabrics, cart.id, products.publisher, products.name as product_name,products.price, cart.product_id as pid, SUBSTRING_INDEX(products.images, ',', 1) AS image, users.username as username, cart.quantity as quantity
FROM cart
INNER JOIN products ON cart.product_id = products.id
INNER JOIN users ON cart.user_id = users.id
WHERE cart.user_id = $user_id";
$cartResult = $db->query($query);
if ($cartResult->num_rows <= 0)
    header('Location:index.php');
if (isset($_POST['pay']) || isset($_POST['pay_online'])) {
    $user_id = $_SESSION['uid'];
    $email = strip_tags($_POST['email'] ?? null);
    $card_number = strip_tags($_POST['card_no'] ?? null);
    $card_expiry = strip_tags($_POST['card_exp'] ?? null);
    $card_cv2 = strip_tags($_POST['card_cv2'] ?? null);
    $card_holder_name = strip_tags($_POST['card_holder'] ?? null);
    $address = strip_tags($_POST['address'] ?? null);
    $state = strip_tags($_POST['state'] ?? null);
    $zip_code = strip_tags($_POST['zip'] ?? null);
    $total = strip_tags($_POST['total']);
    $cartData = $db->query($query);
    $summary = [];
    $summary['total'] = $total;
    while ($row = $cartData->fetch_assoc()) {
        $summary['products'][] = [
            'image' => $row['image'],
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity']
        ];
        $cart = $row['variants'] ?? $row['variant'];
        $quantity = $row['quantity'];
        $publisher = $row['publisher'];
        $price = (int)$row['price'] * (int)$quantity;
        $product_id = $row['pid'];
        $query = "INSERT INTO orders (user_id, email, card_number, card_expiry, card_cv2, card_holder_name, address, state, zip_code, total, cart, publisher, quantity, price, product_id) VALUES ('$user_id', '$email', '$card_number', '$card_expiry', '$card_cv2', '$card_holder_name', '$address', '$state', '$zip_code', '$total', '$cart', '$publisher', '$quantity', '$price', '$product_id')";
        $db->query($query);
    }
    $summary = json_encode($summary);
    $orderId = mysqli_insert_id($db);
    $db->query("INSERT INTO order_summary (user_id,order_id,summary) VALUES ({$_SESSION['uid']}, $orderId, '$summary')");
    $summaryId = mysqli_insert_id($db);
    // clear user's cart
    $del = $db->query("DELETE FROM cart WHERE user_id = {$user_id}");
    header("Location:index.php?success=true&summary=$summaryId");
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
    <title>Mending-Hems | Checkout</title>
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
    <!-- main -->
    <div class="grid grid-cols-12">
        <div class="col-span-12 md:col-span-6 capitalize p-3">
            <div class="summary">
                <p class="font-semibold text-xl font-raleway">order summary</p>
                <p class="text-sm md:w-1/2">check your item and select your shiping for better experience order item</p>
            </div>
            <!-- cart items -->
            <div class="cart mt-3 divide-y border border-stone-300 rounded-md">
                <?php
                $total = 0;
                $vat = rand(10, 20);
                while ($row = $cartResult->fetch_assoc()) {
                    $total += ((float) $row['price'] * (int) $row['quantity']);
                ?>
                    <div class="product-tile flex p-3">
                        <div class="image w-32 h-32 min-w-max border border-stone-300 p-2 rounded-md">
                            <img src="<?php echo $row['image'] ?>" class="w-full h-full rounded-md" alt="">
                        </div>
                        <div class="info grow mx-2">
                            <p class=""><?php echo $row['product_name'] ?></p>
                            <p>x <?php echo $row['quantity'] ?></p>
                            <div class="flex">
                                <?php
                                if ($row['submit_fabrics'] == 1) {
                                ?>
                                    <div title="you have to submit required fabrics at tailor's location" class="flex text-sm bg-stone-800 items-center max-w-fit rounded-sm">
                                        <i class="ri-information-line bg-rose-600 px-1 rounded-l-sm text-white"></i>
                                        <p class="bg-stone-800 text-white rounded-r-sm pl-1 pr-3 text-sm">Submit Fabrics</p>
                                    </div>
                                <?php
                                }
                                if ($row['variants']) {
                                ?>
                                    <div title="you have to submit required fabrics at tailor's location" class="flex text-sm bg-stone-800 items-center max-w-fit rounded-sm">
                                        <i class="ri-information-line bg-rose-600 px-1 rounded-l-sm text-white"></i>
                                        <p class="bg-stone-800 text-white rounded-r-sm pl-1 pr-3 text-sm">Has Variants</p>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if (trim($row['variant'])) {
                                    foreach (explode(',', $row['variant']) as $size) {
                                ?>
                                        <div class="flex text-sm bg-rose-600 mr-2 <?php echo $row['submit_fabrics'] == 1 ? 'ml-2' : '' ?> items-center justify-center max-w-fit rounded-sm">
                                            <p class=" text-white rounded-md px-1 text-sm"><?php echo $size ?></p>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <p class="font-semibold text-xl">₹ <?php echo $row['price'] ?></p>
                        </div>
                        <div class="actions">
                            <a href="delete.php?delete=<?php echo $row['id'] ?>&callback=checkout.php">
                                <div class="border border-stone-300 w-12 flex items-center justify-center rounded-md h-12 text-xl">
                                    <i class="ri-delete-bin-line"></i>
                                </div>
                            </a>
                        </div>
                    </div><?php
                        }
                            ?>
            </div>
            <div class="shipping mt-3">
                <div class="flex items-center">
                    <p class="font-medium mr-2">Available Shipping Methods</p>
                    <i class="ri-information-fill text-lg"></i>
                </div>
                <div class="">
                    <div class="delivary-tile mt-2 flex p-3 border rounded-md border-stone-500">
                        <div class="logo min-w-max p-2 flex items-center justify-center">
                            <p class="text-xl font-black tracking-wide">FEDEX</p>
                        </div>
                        <div class="info grow mx-2">
                            <p class="">Fedex Delivery</p>
                            <p>Delivery: 2-3 days work</p>
                        </div>
                        <div class="actions flex items-center">
                            <div class="flex items-center">
                                <p class="font-semibold text-lg mr-2">Free</p>
                                <input type="radio" name="delivary" checked>
                            </div>
                        </div>
                    </div>
                    <div class="delivary-tile mt-2 flex p-3 border rounded-md border-stone-300">
                        <div class="logo min-w-max p-2 flex items-center justify-center">
                            <p class="text-xl font-black tracking-wide">NATV</p>
                        </div>
                        <div class="info grow mx-2">
                            <p class="">Fedex Delivery</p>
                            <p>Delivery: 2-3 days work</p>
                        </div>
                        <div class="actions flex items-center">
                            <div class="flex items-center">
                                <p class="font-semibold text-lg mr-2">36₹</p>
                                <input type="radio" name="delivary">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-6 p-3 capitalize bg-stone-100">
            <div class="buttons-pay">
                <div class="button">
                    <button id="pay" class="flex items-center bg-gradient-to-r from-teal-600 to-cyan-700 p-3 text-white rounded-md font-raleway tracking-wide font-medium">
                        <p class="mr-2">Pay with NoPay</p>
                        <i class="ri-blaze-line text-3xl"></i>
                    </button>
                </div>
            </div>
            <div class="or flex items-center">
                <div class="w-full h-0.5 roundd-lg bg-stone-600/25"></div>
                <p class="mx-2">or</p>
                <div class="w-full h-0.5 roundd-lg bg-stone-600/25"></div>
            </div>
            <div class="payment-details">
                <p class="font-semibold text-xl font-raleway">Payment Details</p>
                <p class="text-sm md:w-1/2">complete your purchase item by providing your payment details order.</p>
            </div>
            <form action="#" method="post" class="md:w-11/12">
                <label for="email">
                    <p class="my-2 text-sm font-medium">Email Address</p>
                    <div class="input bg-white flex items-center border border-stone-300 rounded-md">
                        <i class="ri-at-line text-xl text-stone-500 ml-3"></i>
                        <input type="email" name="email" class="w-full p-3 rounded-md" placeholder="Enter your email" required>
                    </div>
                </label>
                <label for="card">
                    <p class="my-2 text-sm font-medium">Card Details</p>
                    <div class="input bg-white flex items-center border border-stone-300 rounded-md">
                        <i class="ri-bank-card-line text-xl text-stone-500 ml-3"></i>
                        <input type="text" name="card_no" class="w-full p-3 rounded-md" placeholder="Enter your Card No" required>
                        <input type="text" name="card_exp" pattern="[0-1][0-2]\/[0-9][0-9]" class="rounded-l-none border-l rounded-md border-stone-300 p-3 w-1/2" placeholder="MM/YY" required>
                        <input type="text" name="card_cv2" class="rounded-l-none border-l border-stone-300 p-3 w-1/2 rounded-md" placeholder="CVC" required>
                    </div>
                </label>
                <label for="card-holder">
                    <p class="my-2 text-sm font-medium">Card Holder</p>
                    <div class="input bg-white flex items-center border border-stone-300 rounded-md">
                        <i class="ri-user-line text-xl text-stone-500 ml-3"></i>
                        <input type="text" name="card_holder" class="w-full p-3 rounded-md" placeholder="Enter Card Holder Name" required>
                    </div>
                </label>
                <label for="billing-address">
                    <p class="my-2 text-sm font-medium">Billing Address</p>
                    <div class="input bg-white flex items-center border border-stone-300 rounded-t-md">
                        <img src="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/flags/4x3/in.svg" class="w-8 h-8 ml-3" alt="">
                        <input type="text" name="address" class="w-full p-3 rounded-md" placeholder="Enter your Complete Address" required>
                    </div>
                    <div class="input bg-white flex items-center border-x border-b border-stone-300 rounded-b-md">
                        <input type="text" name="state" class="w-full p-3 rounded-md" placeholder="Enter your State" required>
                        <input type="text" name="zip" class="w-full p-3 rounded-l-none rounded-md border-l border-stone-300" placeholder="Enter Zip" required>
                    </div>
                </label>
                <div class="mt-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <p class="">Subtotal</p>
                            <i class="ri-information-fill ml-2"></i>
                        </div>
                        <p>₹ <?php echo $total ?></p>
                    </div>
                    <div class="flex mt-2 items-center justify-between">
                        <div class="flex items-center">
                            <p class="">Vat(<?php echo $vat ?>%)</p>
                        </div>
                        <p>₹ <?php
                                $gTotal =  $vat * $total / 100;
                                echo number_format($gTotal, 2)
                                ?></p>
                    </div>
                    <div class="flex mt-2 items-center justify-between font-semibold">
                        <div class="flex items-center">
                            <p class="">Total</p>
                        </div>
                        <p>₹ <?php echo number_format($total + $gTotal, 2) ?></p>
                    </div>
                    <input type="hidden" name="total" value="<?php echo number_format($total + $gTotal, 2) ?>">
                    <input type="submit" name="pay" class="bg-stone-900 text-white w-full p-3 rounded-md mt-3" value="Pay ₹ <?php echo number_format($total + $gTotal, 2) ?>">
                </div>
            </form>
        </div>
    </div>
    <!-- pay -->
    <div class="w-screen fixed top-0 bottom-0 h-screen flex items-center justify-center backdrop-pay hidden bg-stone-800/50">
        <div class="md:w-4/12 lg:w-3/12 bg-gradient-to-tr p-3 rounded-md from-teal-600 to-cyan-700">
            <form action="#" method="post" class="flex flex-col">
                <div class="">
                    <i class="ri-meteor-line text-white text-4xl"></i>
                </div>
                <input type="mobile" name="mobile" placeholder="mobile no" class="mb-3 p-3 shadow-md rounded-md" required>
                <input type="text" disabled value="<?php echo number_format($total + $gTotal, 2) ?>" name="amount" placeholder="amount" class="mb-3 p-3 shadow-md rounded-md" required>
                <input type="hidden" name="total" value="<?php echo number_format($total + $gTotal, 2) ?>">
                <input type="submit" name="pay_online" value="Pay" class="bg-gradient-to-br text-white cursor-pointer from-teal-500 to-cyan-700 mb-3 p-3 shadow-md rounded-md">
            </form>
        </div>
    </div>
    <!-- footer -->
    <?php include_once "footer.php" ?>
</body>
<script>
    let backDrop = document.querySelector('.backdrop-pay')
    document.querySelector('.backdrop-pay')
    backDrop.addEventListener("click", function(e) {
        if (e.target !== this)
            return
        this.classList.toggle('hidden')
    })
    document.querySelector("#pay").addEventListener("click", function() {
        document.querySelector('.backdrop-pay').classList.toggle('hidden')
    })
</script>

</html>