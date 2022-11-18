<?php
$Socials = new \App\Models\Socials();
if ((isset($_SESSION['id'])) and ($_SESSION['id'] != '')) {
    $acesso = $Socials->nav_user();
} else {
    $lk = "'" . PATH . COLLECTION . '/social/login' . "'";
    $acesso = '<li class="nav-item" style="list-style-type: none;">';
    $acesso .= '<button class="btn btn-outline-danger" ';
    $acesso .= 'onclick="location.href=' . $lk . ';" ';
    $acesso .= 'style="margin-left: 7px;" type="submit">';
    $acesso .= 'ACESSO';
    $acesso .= '</button>';
    $acesso .= '</li>';
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= PATH.COLLECTION; ?>">GuideMaker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= PATH . COLLECTION; ?>/"><?=lang('guide.guides');?></a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <?php echo $acesso; ?>
        </div>
    </div>
</nav>