<header>
    <div class="banner">
        <div>
            <?php if (!isset($_HEADER_TITLE)) : ?>
            <h2 style="float:left">Welcome <?php echo $login_name; ?></h2>
            <?php else : ?>
            <h2 style="float:left"><?=$_HEADER_TITLE?></h2>
            <?php endif; ?>
            <?php if (!isset($_HEADER_NO_LOGOUT)) : ?>
            <h3 style="float:right;margin:0"><a style="color:white" href="logout.php">Logout</a></h3>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php if(isset($_NORMAL_PAGE)) : ?>
    <div class="navmenu-container"> 
        <div class="navmenu">
            <div class="navmenu-item">
                <a href="my-account.php">My Account</a>
            </div>
            <div class="navmenu-item">
                <a href="add-class-slot.php">Add/Drop Classes</a>
            </div>
            <div class="navmenu-item">
                <a href="view-schedule.php?s=Fall">View Schedule</a>
            </div>
        </div>
    </div>
<?php endif; ?>
