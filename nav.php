<div class="nav">
    <!-- upper-nav -->
    <div class="nav-logo border-b flex items-center justify-around p-3">
        <div class="grow hidden md:block"></div>
        <a href="index.php">
            <div class="logo leading-tight font-raleway font-medium text-left md:text-center uppercase tracking-widest">
                <p class="text-2xl font-semibold">Mending-Hems</p>
                <p class="text-[10px]">indian</p>
            </div>
        </a>
        <div class="grow flex items-center justify-end">
            <div class="misc-btn flex text-xl">
                <div class="search hidden md:flex">
                    <i class="ri-search-line"></i>
                </div>
                <?php
                if (isset($_SESSION['uid']) && $_SESSION['type'] === 'tailor') {
                ?>
                    <a href="tailor/tailor-dashboard.php">
                        <div class="tailor-dashboard hidden md:flex mx-2">
                            <i class="ri-dashboard-line"></i>
                        </div>
                    </a>
                <?php
                }
                if (isset($_SESSION['uid'])) {
                ?>
                    <a href="logout.php">
                        <div class="account hidden md:flex mx-2">
                            <i class="ri-login-box-line"></i>
                        </div>
                    </a>
                <?php
                } else {
                ?>
                    <a href="login.php">
                        <div class="account hidden md:flex mx-2">
                            <i class="ri-user-line"></i>
                        </div>
                    </a>
                <?php
                }
                ?>
                <div class="cart">
                    <i class="ri-shopping-bag-line"></i>
                </div>
                <div class="menu ml-2 block md:hidden">
                    <i class="ri-menu-line"></i>
                </div>
            </div>
        </div>
        <!-- cart menu -->
        <div class="cart-menu-backdrop cursor-pointer absolute flex items-center justify-end h-screen w-screen z-50 top-0 bottom-0 left-0 right-0 bg-stone-900/50">
            <div class="cart-menu overflow-auto cursor-auto w-9/12 md:w-6/12 lg:w-4/12 bg-white h-screen">
                <div class="bg-stone-200 text-center">
                    <div class="cart-close text-2xl w-full flex justify-end p-3">
                        <i class="ri-close-line"></i>
                    </div>
                    <p class="uppercase font-medium pb-3 text-3xl text-stone-700">
                        cart
                    </p>
                </div>
                <?php
                if (isset($_SESSION['uid'])) {
                    $user_id = $_SESSION['uid'];
                    $query = "SELECT cart.id, products.name as product_name, cart.product_id as pid, SUBSTRING_INDEX(products.images, ',', 1) AS image, users.username as username, cart.quantity as quantity
          FROM cart
          INNER JOIN products ON cart.product_id = products.id
          INNER JOIN users ON cart.user_id = users.id
          WHERE cart.user_id = $user_id";

                    $result = $db->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                            <div class="product-cart flex items-center justify-center p-3">
                                <img src="<?php echo $row['image'] ?>" class="w-24 h-24" alt="">
                                <div class="grow pl-2">
                                    <a href="product.php?id=<?php echo $row['pid'] ?>" class=""><?php echo $row['product_name'] ?></a>
                                    <p class="text-lg text-stone-800"><?php echo $row['quantity'] ?></p>
                                </div>
                                <a href="delete.php?delete=<?php echo $row['id'] ?>&callback=index.php">
                                    <div class="actions p-3 bg-stone-300 flex items-center justify-center">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="text-center">
                            <a href="checkout.php">
                                <button class="p-3 bg-black text-white w-9/12">Checkout</button>
                            </a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <p class="text-center p-3">your cart is empty</p>
                    <?php
                    }
                } else {
                    ?>
                    <p class="text-center p-3">login to view</p>
                <?php
                }
                ?>
            </div>
        </div>
        <!-- menu for mobile -->
        <div class="mobile-menu block md:hidden absolute bottom-0 top-0 h-screen w-screen text-stone-800 bg-white z-40">
            <div class="close-menu p-3">
                <i class="ri-close-line text-xl"></i>
            </div>
            <?php
            if (!isset($_SESSION['uid'])) {
            ?>
                <div class="login uppercase font-medium bg-gray-200 px-3 py-6">
                    <div class="flex items-center justify-center tracking-wider">
                        <a href="login.php">login</a>
                        <p class="px-2">or</p>
                        <a href="#">signup</a>
                    </div>
                </div>
                <p class="capitalize text-md p-3">login or signup to continue</p>
                <div class="w-full text-center">
                    <a href="login.php">
                        <button class="uppercase text-white bg-stone-800 p-3 w-11/12">
                            login
                        </button>
                    </a>
                </div>
            <?php
            } else {
            ?>
                <div class="w-full text-center">
                    <a href="logout.php">
                        <button class="uppercase text-white bg-rose-700 p-3 w-11/12">
                            logout
                        </button>
                    </a>
                </div>
            <?php
            }
            ?>
            <div class="menu-title uppercase font-medium text-stone-600 p-3">
                <p>Shop</p>
            </div>
            <div class="menus divide-y">
                <div class="menu uppercase font-medium p-3 flex items-center justify-between">
                    <p>jeans</p>
                    <i class="ri-arrow-right-s-line text-lg"></i>
                </div>
                <div class="menu uppercase font-medium p-3 flex items-center justify-between">
                    <p>Blazers</p>
                    <i class="ri-arrow-right-s-line text-lg"></i>
                </div>
                <div class="menu uppercase font-medium p-3 flex items-center justify-between">
                    <p>Pants</p>
                    <i class="ri-arrow-right-s-line text-lg"></i>
                </div>
                <div class="menu uppercase font-medium p-3 flex items-center justify-between">
                    <p>FW Collections</p>
                    <i class="ri-arrow-right-s-line text-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- lower-nav -->
    <div class="nav-dd relative border-b hidden md:flex p-1 items-center justify-start">
        <div class="dd p-3">
            <div class="dd-title cursor-pointer uppercase text-xs font-roboto flex items-center justify-center">
                <p>
                    blouse
                    <span class="hidden md:inline-block">collections</span>
                </p>
                <i class="ri-arrow-down-s-line ml-1"></i>
            </div>
            <div class="dd-menu grid grid-cols-12 gap-2 absolute botttom-0 cursor-default left-0 p-3">
                <div class="col-span-5 lg:col-span-3">
                    <img src="images/blouse.png" class="w-full" alt="" />
                </div>
                <div class="col-span-7 lg:col-span-9">
                    <div class="available grid grid-cols-12 gap-2">
                        <div class="lg:col-span-6 md:col-span-12 text-justify">
                            <p class="font-medium">Backless blouse</p>
                            <p class="text-sm text-stone-700">
                                Nowadays, Backless blouse is for the most part favored by
                                ladies for wedding, family assembling occasions. Truth be
                                told, B-town divas additionally pick Backless blouses at
                                celebrity main street occasions, initiation services and so
                                on. You can pick weaved, printed, architect floor - length
                                Kurtis.
                            </p>
                        </div>
                        <div class="lg:col-span-6 md:col-span-12 text-justify">
                            <p class="font-medium">Halter-neck blouse</p>
                            <p class="text-sm text-stone-700">
                                In Halter-neck blouses, two comparative or difference folds
                                lay on one another and tied with ties. In present occasions,
                                Halter-neck blouse in Anarkali styles is very high in the
                                pattern. Truth be told, Bollywood divas additionally seen in
                                Halter-neck blouses as they look ladylike and jazzy.
                                Angrakha Kurtis consistently goes well with straight jeans,
                                wedges and oxidized adornments.
                            </p>
                        </div>
                        <div class="lg:col-span-6 md:col-span-12 text-justify">
                            <p class="font-medium">Boat-neck blouse</p>
                            <p class="text-sm text-stone-700">
                                Boat-neck blouses looks flawless on all ladies it is
                                possible that you have an hourglass shape or pear shape.
                                Tights, churidars, Patiala, and palazzos are the clear base
                                that goes well with Boat-neck blouses. At whatever point you
                                need to go to a traditional event, pair Boat-neck blouse
                                with jhumkis, jutis/mojaris.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dd">
            <div class="dd-title cursor-pointer uppercase text-xs font-roboto flex items-center justify-center">
                <p>Kurta</p>
                <i class="ri-arrow-down-s-line ml-1"></i>
            </div>
            <div class="dd-menu grid grid-cols-12 gap-2 absolute botttom-0 cursor-default left-0 p-3">
                <div class="col-span-5 lg:col-span-3">
                    <img src="images/s1.jpg" class="w-full" alt="" />
                </div>
                <div class="col-span-7 lg:col-span-9">
                    <div class="available grid grid-cols-12 gap-2">
                        <div class="lg:col-span-6 md:col-span-12 text-justify">
                            <p class="font-medium">Floor-length Kurti</p>
                            <p class="text-sm text-stone-700">
                                Nowadays, floor-length Kurti is for the most part favored by
                                ladies for wedding, family assembling occasions. Truth be
                                told, B-town divas additionally pick Floor-length Kurtis at
                                celebrity main street occasions, initiation services and so
                                on. You can pick weaved, printed, architect floor - length
                                Kurtis.
                            </p>
                        </div>
                        <div class="lg:col-span-6 md:col-span-12 text-justify">
                            <p class="font-medium">ANGRAKHA KURTI</p>
                            <p class="text-sm text-stone-700">
                                In Angrakha Kurtis, two comparative or difference folds lay
                                on one another and tied with ties. In present occasions,
                                Angrakha Kurti in Anarkali styles is very high in the
                                pattern. Truth be told, Bollywood divas additionally seen in
                                Angrakha Kurtis as they look ladylike and jazzy. Angrakha
                                Kurtis consistently goes well with straight jeans, wedges
                                and oxidized adornments.
                            </p>
                        </div>
                        <div class="lg:col-span-6 md:col-span-12 text-justify">
                            <p class="font-medium">ANARKALI KURTI</p>
                            <p class="text-sm text-stone-700">
                                Anarkali Kurtis looks flawless on all ladies it is possible
                                that you have an hourglass shape or pear shape. Tights,
                                churidars, Patiala, and palazzos are the clear base that
                                goes well with Anarkali Kurtis. At whatever point you need
                                to go to a traditional event, pair Anarkali Kurti with
                                jhumkis, jutis/mojaris.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dd">
            <div class="dd-title cursor-pointer uppercase text-xs font-roboto flex items-center justify-center">
                <p>Salwar & Kameez</p>
                <i class="ri-arrow-down-s-line ml-1"></i>
            </div>
            <div class="dd-menu absolute border-b botttom-0 left-0 p-3">
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque culpa consequuntur, itaque voluptas magni aut soluta
                    eveniet voluptates omnis eum esse accusamus obcaecati voluptate id
                    veniam facere commodi possimus ab.
                </p>
            </div>
        </div>
        <div class="dd">
            <div class="dd-title cursor-pointer uppercase text-xs font-roboto flex items-center justify-center">
                <p>Lehenga</p>
                <i class="ri-arrow-down-s-line ml-1"></i>
            </div>
            <div class="dd-menu absolute border-b botttom-0 left-0 p-3">
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque culpa consequuntur, itaque voluptas magni aut soluta
                    eveniet voluptates omnis eum esse accusamus obcaecati voluptate id
                    veniam facere commodi possimus ab.
                </p>
            </div>
        </div>
        <div class="dd">
            <div class="dd-title cursor-pointer uppercase text-xs font-roboto flex items-center justify-center">
                <p>dress</p>
                <i class="ri-arrow-down-s-line ml-1"></i>
            </div>
            <div class="dd-menu absolute border-b botttom-0 left-0 p-3">
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque culpa consequuntur, itaque voluptas magni aut soluta
                    eveniet voluptates omnis eum esse accusamus obcaecati voluptate id
                    veniam facere commodi possimus ab.
                </p>
            </div>
        </div>
        <div class="dd">
            <a href="profiler.php">
                <div class="dd-title bg-rose-600 text-white p-1 cursor-pointer uppercase text-xs font-roboto flex items-center justify-center">
                    <p>size guide</p>
                    <i class="ri-arrow-right-s-line ml-1"></i>
                </div>
            </a>
        </div>
    </div>
</div>