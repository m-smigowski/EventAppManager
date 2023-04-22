<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Panel Administratora</title>
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>

<?php include 'public/views/elements/header.php'; ?>
<?php include 'public/views/elements/modal.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Panel Administratora</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addEvent">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

                <a href="/register">
                    <button type="button" class="btn btn-secondary btn-lg btn-block">Dodaj użytkownika</button>
                </a>

                <a class='a-btn' href="/modifyEventRole">
                    <button type="button" class="btn btn-secondary btn-lg btn-block">Dodaj/usuń stanowisko</button>
                </a>
                <a class='a-btn' href="/usersList">
                    <button type="button" class="btn btn-secondary btn-lg btn-block">Lista użytkowników</button>
                </a>

        </main>
    </div>
</div>


<?php include 'public/views/elements/scripts.php' ?>
<script>
    $('.nav-link[href="/adminPanel"]').addClass("active");
</script>
</body>
</html>
