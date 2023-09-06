<div class="header">

    <div class="header-left">
        <a href="guardian-home.php" class="logo">
            <img src="../assets/img/logo_logos2.png" alt="Logo" width="37" height="37">
        </a>
        <a href="guardian-home.php" class="logo logo-small">
            <img src="../assets/img/logo_logos.png" alt="Logo" width="30" height="30">
        </a>
    </div>
    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>
    <div class="top-nav-search">
        <form>
            <input type="text" class="form-control" placeholder="Search here">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

    <ul class="nav user-menu">
        <li class="nav-item dropdown noti-dropdown language-drop me-2">
            <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
                <img src="../assets/img/icons/header-icon-01.svg" alt="">
            </a>
            <div class="dropdown-menu ">
                <div class="noti-content">
                    <div>
                        <a class="dropdown-item" href="javascript:;"><i class="flag flag-us me-2"></i>English</a>
                        <a class="dropdown-item" href="javascript:;"><i class="flag flag-la me-2"></i>Laos</a>
                        <a class="dropdown-item" href="javascript:;"><i class="flag flag-cn me-2"></i>Chines</a>
                    </div>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/profile.png" ?>"
                        alt="User Image">
                    <div class="user-text">
                        <h6></h6>
                        <p class="text-muted mb-0"><?php echo $user['status'] ?></p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <!-- <div class="user-header">
                    <div class="avatar avatar-sm">
                        <?php $guardian_image = $guardian['image'];
                                if ($guardian_image == '') { ?>
                        <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/profile.png" ?>"
                            alt="User Image">
                        <?php } else { ?>
                        <img class="rounded-circle" src="<?php echo "../admin/upload/guardian_profile/$guardian_image" ?>"
                            width="31" alt="User Image">
                        <?php } ?>
                    </div>
                    <div class="user-text">
                        <h6><?php echo $guardian['fname_en'] . ' ' . $guardian['lname_en'] ?></h6>
                        <p class="text-muted mb-0"><?php echo $user['status'] ?></p>
                    </div>
                </div> -->
                <!-- <a class="dropdown-item" href="../guardian/guardian-profile.php">My Profile</a> -->
                <a class="dropdown-item" href="../logout.php">Logout</a>
            </div>
        </li>

    </ul>
</div>