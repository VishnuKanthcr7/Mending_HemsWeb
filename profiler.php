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
    $db->query("INSERT INTO profiles (profile_name,profile_data,gender,user_id) VALUES ('$profileName','$profile','M',$uid)");
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
            <div id="leg_length" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-inseam-pants.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-raleway font-medium my-2">Enter Your Leg Length</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>The Inseam Is Measured From The Crotch Along The Inner Side Of The Leg Straight Down To The Floor.</p>
                    </div>
                </div>
                <div class="border-t mt-3 p-3 text-sm">
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">5'5” - 26” inseam</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">5'6" - 26" inseam</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">5'7" - 27" inseam</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">5'8” - 28” inseam</p>
                </div>
            </div>
            <div id="wrist" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-wrist.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">Enter Your Wrist</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>The Wrist Measurement Is Taken As A Circumference Measurement Around Your Wrist.</p>
                    </div>
                </div>
                <div class="border-t mt-3 p-3 text-sm">
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">15" (small)</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">15.5" (medium)</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">16.5" (large)</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">17.5" (extra large)</p>
                </div>
            </div>
            <div id="arm_length" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-wrist.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">Enter Your Arm Length</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>
                            The Sleeve Length Measurement Is Taken From The Point Of Your Shoulder (Where You Took The Shoulder Width Measurement), Following Your Bent Arm Down To Where You Want The Sleeve To End. Bend Your Arm Slightly When Taking This Measurement.</p>
                    </div>
                </div>
                <div class="border-t mt-3 p-3 text-sm">
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">between 31 and 39 inches.</p>
                </div>
            </div>
            <div id="shoulder_width" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-shoulder.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">Enter Your Shoulder Width</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>
                            Think Of A Line Going From Your Armpit Straight Upwards To Your Shoulder. Measure Between Those Two Points And Hold The Tape Measure Straight.</p>
                    </div>
                </div>
            </div>
            <div id="shirt_length" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-shirtlength.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">Enter Your Shirt Length</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>The Shirt Length Measurement Is Taken From The Top Of The Shoulder, Close To The Mid Side Of Your Neck, Following Your Body Down To The Point Where You Want Your Shirt To End.</p>
                    </div>
                </div>
                <div class="border-t mt-3 p-3 text-sm">
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">XL - 29-31</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">2XL - 30-32</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">3XL - 32-34</p>
                </div>
            </div>
            <div id="hip_size" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-hip.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">Enter Your Hip Size</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>
                            The Hip Measurement Is Taken Simply As A Circumference Measurement Around Your Hips At The Widest Part.</p>
                    </div>
                </div>
                <div class="border-t mt-3 p-3 text-sm">
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">M 96-101cm</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">L 105-109cm</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">XL 114-120cm</p>
                </div>
            </div>
            <div id="waist" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-waist.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">Enter Your Waist Size</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>
                            The Waist Measurement Is Taken As A Circumference Measurement Around Your Waist Just Above Your Belly Button. Stand In A Relaxed Posture And Breathe Out</p>
                    </div>
                </div>
            </div>
            <div id="chest" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-chest.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">Enter Your Chest Size</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>The Chest Measurement Is Taken As A Circumference Measurement Around Your Chest At The Widest Point. Stand In A Relaxed Posture And Breathe Out.</p>
                    </div>
                </div>
                <div class="border-t mt-3 p-3 text-sm">
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">Small - 91-97</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">Medium - 99-104</p>
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">Large - 107-112</p>
                </div>
            </div>
            <div id="neck" class="bg-white rounded-md mb-3 flex flex-col w-auto">
                <div class="p-3">
                    <img src="https://images.tailorstore.com/YToyOntzOjU6IndpZHRoIjtzOjQ6IjIwMDAiO3M6NjoiaGVpZ2h0IjtzOjA6IiI7fQ%3D%3D/images/cms/ts-measurements-guide-neck.jpg" class="rounded-md" alt="">
                    <p class="text-xl font-semibold my-2">Enter Your Neck Size</p>
                    <div class="info bg-stone-200 text-sm p-3 rounded-md">
                        <p>
                            The Neck Measurement Is Taken Around The Neck With The Tape Resting On Your Shoulders. You Should Put One Finger Between The Tape And The Neck If You Want To Allow For Some Extra Room.</p>
                    </div>
                </div>
                <div class="border-t mt-3 p-3 text-sm">
                    <p class="bg-stone-200 border rounded-lg p-1 max-w-fit m-1 px-2">42.0 ± 4.8 cm for men</p>
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
                    <p>for female size guide <a class="underline text-rose-700" href="fprofiler.php">visit here</a></p>
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
                            <p class="text-stone-700 mb-2 text-sm">Leg Length</p>
                            <input target="leg_length" type="text" name="leg_length" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Inseam" required />
                        </label>
                    </div>
                    <div class="col-span-1">
                        <label for="wrist">
                            <p class="text-stone-700 mb-2 text-sm">Wrist size</p>
                            <input target="wrist" type="text" name="wrist" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Wrist" required />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="col-span-1">
                        <label for="arm length">
                            <p class="text-stone-700 mb-2 text-sm">Arm Length</p>
                            <input target="arm_length" type="text" name="arm_length" class="rounded-md border border-stone-300 shadow-sm p-3 w-full" placeholder="Arm" required />
                        </label>
                    </div>
                    <div class="col-span-1">
                        <label for="shoulder_width">
                            <p class="text-stone-700 mb-2 text-sm">Shoulder Width</p>
                            <input target="shoulder_width" type="text" name="shoulder_width" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Shoulder" required />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="col-span-1">
                        <label for="shirt_length">
                            <p class="text-stone-700 mb-2 text-sm">Shirt Length</p>
                            <input target="shirt_length" type="text" name="shirt_length" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Shirt length" required />
                        </label>
                    </div>
                    <div class="col-span-1">
                        <label for="hip_size">
                            <p class="text-stone-700 mb-2 text-sm">Hip Size</p>
                            <input target="hip_size" type="text" name="hip_size" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Hip" required />
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
                        <label for="chest">
                            <p class="text-stone-700 mb-2 text-sm">Chest Size</p>
                            <input target="chest" type="text" name="chest" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Chest" required />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="col-span-1">
                        <label for="neck">
                            <p class="text-stone-700 mb-2 text-sm">Neck Size</p>
                            <input target="neck" type="text" name="neck" class="rounded-md border border-stone-300 shadow-sm p-3 w-full " placeholder="Neck" required />
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