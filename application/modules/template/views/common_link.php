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
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-apps"></i><span>Admin</span></a>
                <ul class="ml-menu">
                    <li><a href="<?php echo base_url('fund_type/index'); ?>">Fund type </a></li>
                    <li><a href="<?php echo base_url('fund_type/adds_security_answer'); ?>">Rest Security</a></li>
                    <li><a href="<?php echo base_url('fund_admin_wallet/adds_fund'); ?>">Fund Admin</a></li>
                    <li><a href="<?php echo base_url('fund_admin_wallet/adds_user_fund'); ?>">Fund User </a></li>
                    <li><a href="<?php echo base_url('fund_admin_wallet/index'); ?>">Transaction table </a></li>

                </ul>
            </li>
            <?php endif; ?>

            <?php if ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2): ?>
            <li class="open_top"><a href="javascript:void(0);" class="menu-toggle"><i
                        class="zmdi zmdi-map"></i><span>User</span></a>
                <ul class="ml-menu">
                <li><a href="<?php echo base_url('fund_type/index'); ?>">Fund type </a></li>
                <li><a href="<?php echo base_url('fund_admin_wallet/index'); ?>">Transaction table </a></li>
                <!-- <li><a href="<?php //echo base_url('fund_type/index'); ?>">Fund type </a></li> -->
                </ul>
            </li>
            <?php endif; ?>

            <a href="<?php echo site_url('auth/sign_out') ?>" class="dropdown-item">
								<i data-feather="power"></i>
								<span>Logout</span>
							</a>
        </ul>
    </div>
</aside>