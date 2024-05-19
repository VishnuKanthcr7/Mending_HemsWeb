<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:login.php');
}
require_once("utils/Db.php");
$db = Db::getInstance();
if (!isset($_GET['pid'])) {
    header('Location:index.php');
}
if (isset($_POST['cart'])) {
    $user_id = $_SESSION['uid'];
    $product_id = $_POST['pid'];
    $quantity = 1;
    $query = "SELECT quantity FROM cart WHERE product_id = $product_id AND user_id = $user_id";
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        $query = "UPDATE cart SET quantity = quantity + $quantity, variants = '{$_POST['variants']}' WHERE product_id = $product_id AND user_id = $user_id";
    } else {
        $query = "INSERT INTO cart (product_id, quantity, user_id, variants) VALUES ('$product_id', '$quantity', '$user_id', '{$_POST['variants']}')";
    }
    $db->query($query);
    header('Location:checkout.php');
}
$pid = $_GET['pid'];
$res = $db->query("SELECT customize.*,products.price FROM `customize` INNER JOIN products ON customize.product_id = products.id WHERE product_id = $pid;");
if ($res->num_rows <= 0) {
    header('Location:index.php');
}
$data = $res->fetch_assoc();
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
    <title>Customize | <?php echo $pid ?></title>
</head>

<body class="grid grid-cols-12 w-screen h-screen bg-gradient-to-tr from-rose-600 to-rose-700">
    <div class="col-span-12 md:col-span-2 lg:col-span-1 options flex flex-row md:flex-col">
    </div>
    <div class="col-span-12 md:col-span-2 dd">
    </div>
    <div class="col-span-12 relative md:col-span-8 lg:col-span-9 present flex items-center justify-center flex-col">
    </div>
    <div class="price fixed top-0 right-0 m-3 text-3xl font-bold text-white font-roboto">
        <p><span class="finalPrice"><?php echo $data['price'] ?></span> ₹</p>
    </div>
    <div class="fixed flex bottom-0 right-0 m-3">
        <div class="hidden add-to-cart bg-white p-3 mr-2 shadow-sm rounded-md cursor-pointer">
            <form action="#" method="post">
                <input type="hidden" name="pid" value="<?php echo $pid ?>">
                <input type="hidden" name="variants">
                <input type="hidden" name="price">
                <input type="submit" value="add to cart" name="cart">
            </form>
        </div>
        <div class="price bg-white p-3 rounded-md cursor-pointer">
            <a href="profiler.php" class="bg-white">
                <p>continue</p>
            </a>
        </div>
    </div>
</body>
<script>
    let price = parseInt(document.querySelector('.finalPrice').innerText)
    let prevPrice = document.querySelector('.finalPrice')
    let picked = {}
    const calculatePrice = (data) => {
        let final = 0
        for (d in data) {
            final += data[d].price
        }
        return final + price
    }

    function getValueAtPath(path, obj) {
        console.log(path)
        return path.split('.').reduce((prev, curr) => prev ? prev[curr] : undefined, obj);
    }
    let choosed = {}
    let data = <?php echo $data['map'] ?>

    if ('fabric' in data) {
        document.querySelector('.options').innerHTML += `
        <div path="fabric" class="tile m-1 rounded-md bg-white flex items-center justify-center flex-col p-3">
            <img src="${data.fabric.icon}" alt="">
            <p>Fabric</p>
        </div>
        `
    }
    for (i in data.options) {
        document.querySelector('.options').innerHTML += `
        <div path="options.${i}" class="tile m-1 rounded-md bg-white flex items-center justify-center flex-col p-3">
            <img src="${data.options[i].icon}" alt="">
            <p>${i}</p>
        </div>
        `
    }
    document.querySelectorAll('.tile').forEach((el) => {
        el.addEventListener('click', function(e) {
            let path = this.getAttribute('path')
            let pathData = getValueAtPath(path, data)
            console.log(pathData)
            document.querySelector('.dd').innerHTML = ''
            pathData.data.forEach((d) => {
                console.log(d)
                document.querySelector('.dd').innerHTML += `
                <div price="${d.price}" path="${path + ':' + d.name}" data="${d.data}" class="dd-tile m-1 rounded-md bg-white flex flex-col items-center justify-center p-3">
                    <img src="${d.icon}" alt="" class="h-24">
                    <p>${d.name}</p>
                </div>
                `
            })
        })
    })
    document.addEventListener("click", function(e) {
        const target = e.target.closest(".dd-tile");
        if (target) {
            let img = target.getAttribute('data')
            const [item, type] = target.getAttribute('path').split(':')
            picked[item.trim()] = {
                name: type.trim(),
                price: parseInt(target.getAttribute('price'))
            }
            let finalPrice = calculatePrice(picked)
            document.querySelector('.add-to-cart').classList.remove('hidden')
            document.querySelector('.finalPrice').innerText = finalPrice
            document.querySelector('input[name="variants"]').value = JSON.stringify(picked)
            document.querySelector('input[name="price"]').value = finalPrice
            document.querySelector('.present').innerHTML = `
            <img src="${img}" class="scale-in-ver-top rounded-md max-h-96 lg:w-5/12 lg:w-5/12 md:w-6/12 md:h-5/12"/>
            `
        }
    });
</script>

</html>