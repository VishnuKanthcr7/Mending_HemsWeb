<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:/mending-hems/index.php');
}
if (!isset($_GET['pid'])) {
    header('Location:/mending-hems/index.php');
}
require_once("utils/Db.php");
$db = Db::getInstance();
$pid = $_GET['pid'];
$product = $db->query("SELECT products.*, customize.* FROM products LEFT JOIN customize ON products.id = customize.product_id WHERE products.id = $pid AND publisher = {$_SESSION['uid']}");
if ($product->num_rows === 0) {
    header('Location:/mending-hems/index.php');
}
$product = $product->fetch_assoc();
$errors = [];
function uploadImage($files)
{
    $res = [];
    $files = $_FILES["file"];
    // Loop through each file in the array
    foreach ($files["name"] as $key => $value) {
        $file = array(
            'name' => $files['name'][$key],
            'type' => $files['type'][$key],
            'tmp_name' => $files['tmp_name'][$key],
            'error' => $files['error'][$key],
            'size' => $files['size'][$key]
        );
        // Allowed image extensions
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $file["name"]);
        $extension = end($temp);
        // Check if the file is an image and has a valid extension
        if ((($file["type"] == "image/gif")
                || ($file["type"] == "image/jpeg")
                || ($file["type"] == "image/jpg")
                || ($file["type"] == "image/pjpeg")
                || ($file["type"] == "image/x-png")
                || ($file["type"] == "image/png"))
            && in_array($extension, $allowedExts)
        ) {
            // Check if there were any errors during the file upload
            if ($file["error"] > 0) {
                return false;
            } else {
                $file["name"] = (string) random_int(10000, 9999999) . '.' . $extension;
                move_uploaded_file($file["tmp_name"], dirname(__DIR__) . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $file["name"]);
                $res[] = 'http://localhost/mending-hems/images/' . $file["name"];
            }
        } else {
            return false;
        }
    }
    return implode(',', $res);
}
function isValidJSON($str)
{
    json_decode($str);
    return (json_last_error() == JSON_ERROR_NONE);
}

if (isset($_POST['add'])) {
    $resp = uploadImage($_FILES);
    if (!$resp)
        $resp['file'] = false;
    else $_POST['images'] = $resp;
    $_POST['publish'] = $_POST['publish'] === 'on' ? 1 : 0;
    $_POST['accept_fabric'] = $_POST['accept_fabric'] === 'on' ? 1 : 0;
    if (!isValidJSON($_POST['attributes']))
        $errors['attributes'] = false;
    if (isset($_POST['customize']) && trim($_POST['customize']) && !isValidJSON($_POST['customize']))
        $errors['customize'] = false;
    if (!$errors) {
        $isImage = isset($_POST['files']) ? ", images = '{$_POST['images']}" : '';
        $query = "UPDATE products SET price = {$_POST['price']} $isImage, sizes = '{$_POST['size']}', attributes = '{$_POST['attributes']}',active = {$_POST['publish']}, name = '{$_POST['name']}', category = '{$_POST['category']}', description = '{$_POST['description']}', accept_fabrics = {$_POST['accept_fabric']}  WHERE id = $pid";
        $query;
        $db->query($query);
        // insert customization data
        if (isset($_POST['customize']) && isValidJSON($_POST['customize'])) {
            if ($db->query("SELECT id FROM customize WHERE product_id = $pid")->num_rows > 0) {
                $db->query("UPDATE customize SET map = '{$_POST['customize']}' WHERE product_id = $pid");
            } else {
                $db->query("INSERT INTO customize (product_id, map) VALUES ($pid ,'{$_POST['customize']}')");
            }
        }
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
    <title>Mending-Hems</title>
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
                    <div class="link flex items-center p-3 hover:bg-stone-200 cursor-pointer">
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
                    <div class="link flex items-center p-3 bg-stone-200 cursor-pointer">
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
        <?php
        if (!$errors && isset($_POST['add'])) {
        ?>
            <p class="text-green-500 p-3">Product was updated</p>
        <?php
        }
        ?>
        <form action="#" method="post" class="p-3" enctype="multipart/form-data">
            <label for="name">
                <input type="text" name="name" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Name" required value="<?php echo $product['name'] ?>" />
            </label>
            <label for="price">
                <input type="number" min="1" name="price" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Price" required value="<?php echo $product['price'] ?>" />
            </label>
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-6">
                    <label for="size">
                        <input type="text" name="size" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Sizes comma seperated SM,MD,XL" required value="<?php echo $product['sizes'] ?>" />
                    </label>
                </div>
                <div class="col-span-6">
                    <label for="category">
                        <input type="text" name="category" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" placeholder="Category" required value="<?php echo $product['category'] ?>" />
                    </label>
                </div>
            </div>
            <div class="files">
                <label for="file">
                    <input type="file" accept="image/png, image/jpeg" multiple name="file[]" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" />
                </label>
                <div class="file-holder hidden flex shrink-0 overflow-x-auto mt-3 p-3 border border-stone-300 rounded-md"></div>
            </div>
            <div class="grid grid-cols-12">
                <div class="col-span-6 mt-3 flex items-center justify-center">
                    <p>Accept fabrics</p>
                    <label for="name">
                        <input type="checkbox" name="accept_fabric" class="m-1" <?php echo $product['accept_fabrics'] ? 'checked' : '' ?> />
                    </label>
                </div>
                <div class="col-span-6 mt-3 flex items-center justify-center">
                    <p>Publish</p>
                    <label for="name">
                        <input type="checkbox" name="publish" class="m-1" checked />
                    </label>
                </div>
            </div>
            <label for="description">
                <textarea name="description" placeholder="Description" class="rounded-md border border-stone-300 shadow-sm p-3 w-full mt-3" cols="30" rows="8" required><?php echo ucfirst(trim($product['description'])) ?>
                </textarea>
            </label>
            <label for="attributes">
                <textarea name="attributes" placeholder="Attributes (json)" class="rounded-md border <?php echo isset($errors['attributes']) ? 'border-rose-500' : 'border-stone-300' ?> shadow-sm p-3 w-full mt-3" cols="30" rows="8" required><?php echo json_encode(json_decode($product['attributes']), JSON_PRETTY_PRINT) ?></textarea>
            </label>
            <p class="mt-1">Customization (optional)</p>
            <label for="customize">
                <textarea name="customize" placeholder="Customize (json)" class="rounded-md border <?php echo isset($errors['customize']) ? 'border-rose-500' : 'border-stone-300' ?> shadow-sm p-3 w-full mt-3" cols="30" rows="8"><?php $x = json_encode(json_decode($product['map']), JSON_PRETTY_PRINT);
                                                                                                                                                                                                                                    echo $x == 'null' ? '' : $x  ?></textarea>
            </label>
            <input type="submit" name="add" value="Update Product" class="w-full bg-stone-800 text-white p-3 rounded-md mt-3">
        </form>
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
    document.querySelector('input[name="file[]"]').addEventListener('change', (e) => {
        document.querySelector('.file-holder').innerHTML = ''
        document.querySelector('.file-holder').classList.add('hidden')
        for (let file of e.target.files) {
            document.querySelector('.file-holder').classList.remove('hidden')
            document.querySelector('.file-holder').innerHTML += `
            <img src="${URL.createObjectURL(file)}" class="w-32 m-3 rounded-md"/>
            `
        }
    })
</script>

</html>