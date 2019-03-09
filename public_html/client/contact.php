<?php $page_title = "Contact Us"; ?>
<?php require_once('../../private-client/initialize.php');
require(CLIENT.'head.php');
checkLog();
makeNav($page_title);

?>
<div class="container">

    <?php
        $msg = h('Contact the team of experts', 50, 'bold');
        $phone = h('Phone: (222) 333-4444', 30, 'bold');
        $email = h('Email: Coche@rent.car', 30, 'bold');
        $business = 'M-F: 9am to 5pm <br> Sat: 10am to 2pm <br> Sun: <strong>CLOSED</strong>';
        $hours = h($business, 30, 'bold');
        echo centerRow($msg);
        echo centerRow($phone);
        echo centerRow($email);
        echo centerRow($hours);
        ediv(180);

    ?>

</div>

<script>
    $("body").addClass("rad-background");
    $("p").css('color', 'white');
</script>
<?php require_once(CLIENT . 'tidy-up.php'); ?>
