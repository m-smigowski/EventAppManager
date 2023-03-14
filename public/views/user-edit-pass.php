<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Zmiana hasła</title>
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
                <h1 class="h3">Zmiana hasła</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addEvent">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>


            <section class="user-edit">
                <form class="w-75" action="userUpdatePass" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-outline mb-2">
                        <input name="old_password" type="password" class="form-control" required/>
                        <label class="form-label">Podaj stare hasło</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="new_password" type="password" class="form-control" required/>
                        <label class="form-label">Podaj nowe hasło</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="confirmed_pass" type="password" class="form-control" required/>
                        <label class="form-label">Powtórz nowe hasło</label>
                    </div>

                    <button type="submit" class="btn btn-success" value="Zaktualizuj" name="UserPassUpdate">
                        Zaktualizuj
                    </button>
                    <button type="submit" class="btn btn-danger">Wróć</button>
                </form>
            </section>

        </main>
    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>
<script>$('.nav-item [href="/usersPanel"]').addClass("active");<?php echo $display; ?></script>

</body>
</html>
