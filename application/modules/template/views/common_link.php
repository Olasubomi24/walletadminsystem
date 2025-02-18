

<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_email']) || empty($_SESSION['user_email'])) {
    session_destroy();
    header("Location: auth/sign_out");
    exit();
}
?>


<div class="page-loader-wrapper">

</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Main Search -->
<div id="search">
    <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
    <form>
        <input type="search" value="" placeholder="Search..." />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<!-- Right Icon menu Sidebar -->


<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href=""><span class="m-l-10">Wallet System</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="profile.html"><img src="assets/images/profile_av.jpg" alt="User"></a>
                    <div class="detail">
                        <h4><?php echo $_SESSION['user_name'] ?></h4>
                        <small><?php echo ($_SESSION['user_type_id'] == 1) ? 'Admin' : 'Super Admin'; ?></small>
                    </div>
                </div>
            </li>
            <li class="active open"><a href=""><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            <?php if ($_SESSION['user_type_id'] == 2): ?>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-apps"></i><span>App</span></a>
                <ul class="ml-menu">
                    <li><a href="">Tables</a></li>
                    <li><a href="chat.html">Chat Apps</a></li>
                    <li><a href="events.html">Calendar</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <?php if ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2): ?>
            <li class="open_top"><a href="javascript:void(0);" class="menu-toggle"><i
                        class="zmdi zmdi-map"></i><span>Maps</span></a>
                <ul class="ml-menu">
                    <li><a href="google.html">Google Map</a></li>
                    <li><a href="yandex.html">YandexMap</a></li>
                    <li><a href="jvectormap.html">jVectorMap</a></li>
                </ul>
            </li>
            <?php endif; ?>


        </ul>
    </div>
</aside>