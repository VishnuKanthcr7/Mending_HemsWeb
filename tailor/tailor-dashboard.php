<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:index.php');
}
require_once("utils/Db.php");
$db = Db::getInstance();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com" defer></script>
    <link href="../dist/output.css" rel="stylesheet" />
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
    <title>Mending-Hems | Tailor Dashboard</title>
</head>
<style>
    * {
        transition: 0.3s all ease;
    }

    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<body class="grid grid-cols-12 font-roboto overflow-hidden">
    <div class="col-span-2 flex flex-col h-screen border-r divide-y">
        <div class="logo p-3 leading-tight font-raleway font-medium text-left uppercase tracking-widest">
            <p class="text-xl font-semibold">Mending-Hems</p>
            <p class="text-[10px]">indian</p>
        </div>
        <div class="links grow divide-y text-stone-800 flex flex-col">
            <div class="upper-links grow">
                <a href="tailor-dashboard.php">
                    <div class="link flex items-center p-3 bg-stone-200 cursor-pointer">
                        <i class="ri-dashboard-2-line text-xl mr-2"></i>
                        <p class="font-medium tracking-wide">Dashboard</p>
                    </div>
                </a>
                <a href="all-products.php">
                    <div class="link flex items-center p-3 hover:bg-stone-200 cursor-pointer">
                        <i class="ri-shirt-line text-xl mr-2"></i>
                        <p class="font-medium tracking-wide">All Products</p>
                    </div>
                </a>
                <a href="add-product.php">
                    <div class="link flex items-center p-3 hover:bg-stone-200 cursor-pointer">
                        <i class="ri-add-line text-xl mr-2"></i>
                        <p class="font-medium tracking-wide">Add Product</p>
                    </div>
                </a>
            </div>
            <div class="lower-links">
                <a href="../logout.php">
                    <div class="link flex items-center p-3 hover:bg-stone-200 cursor-pointer">
                        <i class="ri-logout-circle-r-line text-xl mr-2"></i>
                        <p class="font-medium tracking-wide">Log out</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-span-7 divide-y  h-screen overflow-y-auto">
        <div class="orders p-3">
            <p class="p-3">Recent orders</p>
            <table class="w-full">
                <thead>
                    <th class="border p-3">product name</th>
                    <th class="border p-3">buyer</th>
                    <th class="border p-3">quantity</th>
                    <th class="border p-3">price</th>
                    <th class="border p-3">customization</th>
                </thead>
                <tbody>
                    <?php
                    $orders = $db->query("SELECT users.*, products.*, orders.* FROM orders INNER JOIN products ON orders.product_id = products.id INNER JOIN users on users.id = orders.user_id WHERE orders.publisher = {$_SESSION['uid']}");
                    if ($orders->num_rows > 0) {
                        while ($row = $orders->fetch_assoc()) {
                    ?>
                            <tr>
                                <td class="p-3 border"><?php echo $row['name'] ?></td>
                                <td class="p-3 border"><?php echo $row['username'] ?></td>
                                <td class="p-3 border"><?php echo $row['quantity'] ?></td>
                                <td class="p-3 border"><?php echo $row['price'] ?> ₹</td>
                                <td class="p-3 border"><?php
                                                        $customization = json_decode($row['cart'], true) ?? [];
                                                        foreach ($customization as $key => $value) {
                                                        ?>
                                        <p class="bg-rose-600 text-white p-1 rounded-md flex items-center"><i class="ri-record-circle-fill mr-1 text-xs"></i> <?php echo $key ?></p>
                                        <div class="m-1 flex items-center">
                                            <div class="w-4 rotate-90 h-0.5 rounded-md bg-rose-700"></div>
                                            <div class="w-4 h-0.5 rounded-md bg-rose-900"></div>
                                            <p class="p-1 grow rounded-md bg-rose-400 text-white flex items-center"><i class="ri-record-circle-fill mr-1 text-xs"></i> <?php echo $value['name'] ?></p>
                                        </div>
                                        <div class="m-1 flex items-center">
                                            <div class="w-4 rotate-90 h-0.5 rounded-md bg-rose-700"></div>
                                            <div class="w-4 h-0.5 rounded-md bg-rose-900"></div>
                                            <p class="p-1 grow rounded-md bg-rose-500 text-white pl-2"><?php echo $value['price'] ?> ₹</p>
                                        </div>
                                    <?php
                                                        } ?>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <p>no orders</p>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-span-3 divide-y border-l h-screen overflow-y-scroll">
        <?php
        $products = $db->query("SELECT *, SUBSTRING_INDEX(images, ',', 1) AS image  FROM products WHERE publisher = {$_SESSION['uid']} LIMIT 6");
        while ($row = $products->fetch_assoc()) {
        ?>
            <div class="product relative flex flex-col">
                <img src="<?php echo $row['image'] ?>" class="grow w-full" alt="">
                <div class="info flex items-center bg-white rounded-b-md p-3">
                    <div class="grow">
                        <p class="font-medium"><?php echo $row['name'] ?></p>
                        <p><?php echo $row['price'] ?></p>
                    </div>
                    <a href="edit-product.php?pid=<?php
                                                    echo $row['id'] ?>" class="grow flex items-center justify-center">
                        <i class="ri-edit-line text-xl"></i>
                    </a>
                </div>
                <a href="delete.php?pid=<?php echo $row['id'] ?>" class="delete bg-white flex items-center justify-center rounded-md w-10 h-10 border-rose-600 absolute top-0 right-0 m-3 shadow-md">
                    <i class="ri-delete-bin-line text-xl text-rose-700"></i>
                </a>
            </div>
        <?php
        }
        ?>
    </div>
</body>
<script>
</script>

</html>