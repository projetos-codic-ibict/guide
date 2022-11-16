    <style>
        .body-full {
            height: 100vh;
            color: white;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 bg-primary  body-full">
                <h1>MENU</h1>
                <?php echo $menu; ?>
            </div>
            <div class="col-md-9">
                <?php echo $content; ?>
            </div>
        </div>
    </div>