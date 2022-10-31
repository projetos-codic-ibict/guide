    <style>
        .body-full  {
            height: 100vh;
        }
        .logo {
            background-image: url('<?= getenv("app.baseURL"); ?>/img/background/bg.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>

<div class="comtainer">
    <div class="row">
        <div class="col-6 logo body-full">
            <img src="<?= getenv("app.baseURL"); ?>/img/logo/logo_big-trans.png" class="mt-5 p-5 img-fluid">
        </div>
        <div class="col-6 mt-5">
            <?php
                echo $login;
            ?>
        <?div>
        </div>
    </div>