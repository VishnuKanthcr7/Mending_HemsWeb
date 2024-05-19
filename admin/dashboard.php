<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:index.php');
}
require_once("utils/Db.php");
$db = Db::getInstance();
if (isset($_GET['uid']) && isset($_GET['action'])) {
    [$uid, $action] = [$_GET['uid'], $_GET['action']];
    if ($action === 'status') {
        $db->query("UPDATE users SET active = CASE WHEN active = 0 THEN 1 WHEN active = 1 THEN 0 END WHERE id = $uid;");
    }
    if ($action === 'delete') {
        $db->query("DELETE FROM users WHERE id = $uid");
    }
}
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
    <title>Mending-Hems | Admin Dashboard</title>
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
                    <th class="border p-3"></th>
                    <th class="border p-3">username</th>
                    <th class="border p-3">email</th>
                    <th class="border p-3">phone</th>
                    <th class="border p-3">type</th>
                    <th class="border p-3">account status</th>
                </thead>
                <tbody>
                    <?php
                    $orders = $db->query("SELECT * from users where type != 'admin'");
                    if ($orders->num_rows > 0) {
                        while ($row = $orders->fetch_assoc()) {
                    ?>
                            <tr>
                                <td class="p-3 border">
                                    <a href="/mending-hems/admin/dashboard.php?uid=<?php echo $row['id'] ?>&action=delete" class="delete bg-white flex items-center justify-center rounded-md w-10 h-10 border border-rose-200 hover:ring-2 hover:ring-offset-2 hover:ring-rose-600 shadow-md">
                                        <i class="ri-delete-bin-line text-xl text-rose-700"></i>
                                    </a>
                                </td>
                                <td class="p-3 border"><?php echo $row['username'] ?></td>
                                <td class="p-3 border"><?php echo $row['email'] ?></td>
                                <td class="p-3 border"><?php echo $row['phone'] ?></td>
                                <td class="p-3 border"><?php echo $row['type'] ?></td>
                                <td class="p-3 border">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input uid="<?php echo $row['id'] ?>" type="checkbox" value="" class="sr-only peer toggle-status" <?php echo $row['active'] == 1 ? "checked" : "" ?>>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    </label>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <p>no users found</p>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-span-3 divide-y border-l h-screen overflow-y-scroll">
        <?php
        $top = $db->query("SELECT users.username as username, SUM(orders.total) as total FROM `orders` INNER JOIN users ON orders.publisher = users.id GROUP BY orders.publisher LIMIT 3;");
        unset($row);
        if ($top->num_rows ?? null >= 1) {
        ?>
            <div class="p-3">
                <div class="">
                    <p>Top tailors</p>
                </div>
                <?php
                while ($row = $top->fetch_assoc()) {
                ?>
                    <div class="flex items-center mt-3">
                        <div class="avatar w-12 h-12 font-bold bg-rose-300 rounded-full flex items-center justify-center text-xl uppercase">
                            <p><?php echo $row['username'][0] . $row['username'][1] ?></p>
                        </div>
                        <div class="ml-2">
                            <p class="capitalize"><?php echo $row['username'] ?></p>
                            <p class="text-sm text-stone-600"><?php echo $row['total'] ?> ₹</p>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            </div>
    </div>
</body>
<script>
    document.querySelectorAll('.toggle-status').forEach((el) => {
        el.addEventListener('change', function(e) {
            window.location = `
            http://localhost/mending-hems/admin/dashboard.php?uid=${this.getAttribute('uid')}&action=status
            `
        })
    })
</script>

</html>