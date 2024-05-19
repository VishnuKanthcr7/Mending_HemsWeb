<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:login.php');
}
if (isset($_POST['submit'])) {
    require_once("utils/Db.php");
    $db = Db::getInstance();
    $profileName = $_POST['profile_name'];
    unset($_POST['profile_name'], $_POST['submit']);
    $profile = json_encode($_POST);
    $uid = $_SESSION['uid'];
    $db->query("INSERT INTO profiles (profile_name,profile_data,gender,user_id) VALUES ('$profileName','$profile','F',$uid)");
    header('Location:index.php?msg=profile saved successfuly');
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
    <title>Mending-Hems | Profile</title>
</head>
<style>
    * {
        transition: 0.3s all ease;
        scroll-behavior: smooth;
    }

    ::-webkit-scrollbar {
        width: 0px;
    }
</style>

<body class="font-roboto">
    <div class="h-screen w-screen grid grid-cols-12 bg-stone-200">
        <div class="col-span-12 md:col-span-4 lg:col-span-3 p-3 overflow-y-scroll">
            <div id="neck" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-19_large.jpg?2939959681708555958" class="rounded-md" alt="">
                    <p class="text-xl font-raleway font-medium my-2">NECK</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>Measure around the neck with one finger included.</p>
                    </div>
                </div>
            </div>
            <div id="neck_opening" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-20_large.jpg?11777741815446480008" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">NECK OPENING</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>Measure from the center of the front neck to the top of your bust.</p>
                    </div>
                </div>
            </div>
            <div id="shoulder" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-22_large.jpg?1425316536188333720" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">SHOULDER</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>Measure straight from the edge of one shoulder to the other at the back.</p>
                    </div>
                </div>
            </div>
            <div id="bust_distance" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-4_large.jpg?4507944240225382883" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">BUST DISTANCE</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>Measure from one bust point to the other.</p>
                    </div>
                </div>
            </div>
            <div id="arm" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-15_large.jpg?4507944240225382883" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">ARM HOLE</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>Measure around the arm from the shoulder tip to arm pit and back to shoulder tip.</p>
                    </div>
                </div>
            </div>
            <div id="sleeve_length" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-13_large.jpg?4507944240225382883" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">SLEEVE LENGTH</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>
                            Measure from the tip of the shoulder to the base of the thumb for long-sleeve or to desired sleeve length for short-sleeve.</p>
                    </div>
                </div>
            </div>
            <div id="waist" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-5_large.jpg?4507944240225382883" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">WAIST</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>Measure your natural waist all the way around your body.</p>
                    </div>
                </div>
            </div>
            <div id="hips" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-7_large.jpg?15076995560213562887" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">HIP</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>Measure all the way around your body at the fullest part of your hips.</p>
                    </div>
                </div>
            </div>
            <div id="dress_length" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://cdn.shopify.com/s/files/1/0415/7737/files/BW_Womens_Measuring_Guide-17_2_large.jpg?15169683915692692889" class="rounded-md w-full" alt="">
                    <p class="text-xl font-semibold my-2">DRESS LENGTH</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>Measure from the tip of the shoulder over the fullest part of bust to desired dress length or to the floor (without heels) for full-length dresses.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 h-[50vh] md:h-auto md:col-span-8 lg:col-span-9 bg-white">
            <div class="flex flex-col md:flex-row p-3 items-start md:items-center justify-between">
                <div class="">
                    <p class="text-2xl font-medium font-raleway">Size Guide</p>
                    <p>provide your best and accurate details.</p>
                </div>
                <div class="">
                    <p>for male size guide <a class="underline text-blue-700" href="fprofiler.php">visit here</a></p>
                </div>
            </div>
            <form action="#" method="post" class="p-3 overflow-scroll">
                <div class="grid grid-cols-2 gap-2">
                    <div class="col-span-2">
                        <label for="name">
                            <p class="text-stone-700 mb-2 text-sm">Profile Name</p>
                            <input type="text" name="profile_name" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Profile Name" required />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="col-span-1">
                        <label for="Leg Length">
                            <p class="text-stone-700 mb-2 text-sm">Neck Length</p>
                            <input target="neck" type="text" name="neck" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="neck" required />
                        </label>
                    </div>
                    <div class="col-span-1">
                        <label for="wrist">
                            <p class="text-stone-700 mb-2 text-sm">Neck Opening</p>
                            <input target="neck_opening" type="text" name="neck_opening" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Neck" required />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="col-span-1">
                        <label for="arm length">
                            <p class="text-stone-700 mb-2 text-sm">Shoulder Length</p>
                            <input target="shoulder" type="text" name="shoulder_length" class="rounded-md border border-stone-300 shadow-sm p-3 w-full" placeholder="Shoulder" required />
                        </label>
                    </div>
                    <div class="col-span-1">
                        <label for="bust_distance">
                            <p class="text-stone-700 mb-2 text-sm">Bust Distance</p>
                            <input target="bust_distance" type="text" name="bust_distance" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Bust" required />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="col-span-1">
                        <label for="arm">
                            <p class="text-stone-700 mb-2 text-sm">Arm Hole</p>
                            <input target="arm" type="text" name="arm" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Arm" required />
                        </label>
                    </div>
                    <div class="col-span-1">
                        <label for="sleeve_length">
                            <p class="text-stone-700 mb-2 text-sm">Sleeve Length</p>
                            <input target="sleeve_length" type="text" name="sleeve_length" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Sleeve" required />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="col-span-1">
                        <label for="waist">
                            <p class="text-stone-700 mb-2 text-sm">waist size</p>
                            <input target="waist" type="text" name="waist" class="rounded-md border border-stone-300 shadow-sm p-3 w-full" placeholder="Waist" required />
                        </label>
                    </div>
                    <div class="col-span-1">
                        <label for="hips">
                            <p class="text-stone-700 mb-2 text-sm">Hips Size</p>
                            <input target="hips" type="text" name="hips" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="hips" required />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="col-span-1">
                        <label for="dress_length">
                            <p class="text-stone-700 mb-2 text-sm">Dress Length</p>
                            <input target="dress_length" type="text" name="dress_length" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Dress Length" required />
                        </label>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <p class="mt-2 md:mt-4"></p>
                        <input type="submit" name="submit" class="bg-stone-800 rounded-md text-white p-3 w-full mt-3" value="save">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    document.querySelectorAll('input').forEach((el) => {
        el.addEventListener('focus', function(e) {
            let targetCard = el.getAttribute("target")
            document.querySelector(`div[id="${targetCard}"]`).scrollIntoView()
        })
    })
</script>

</html>