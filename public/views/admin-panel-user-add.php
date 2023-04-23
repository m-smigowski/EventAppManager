<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Lista użytkowników aplikacji</title>
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
                <h1 class="h3">Dodaj użytkownika</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="user-register box w-50">
                <form class="addUser" action="addUser" method="POST">
                    <div class="form-outline mb-2">
                        <label class="form-label">Adres E-Mail</label>
                        <input name="email" type="text" class="form-control" required/>
                    </div>

                    <div class="form-outline mb-2">
                        <label class="form-label">Imię</label>
                        <input name="name" type="text" class="form-control" required/>
                    </div>
                    <div class="form-outline mb-2">
                        <label class="form-label" ">Nazwisko</label>
                        <input name="surname" type="text" class="form-control" required/>
                    </div>
                    <div class="form-outline mb-2">
                        <label class="form-label">Telefon</label>
                        <input name="phone" type="number" class="form-control" required/>
                    </div>


                    <button type="submit" class="btn btn-success btn-up" value="Zaktualizuj" name="UserUP">
                        Zarejestruj
                    </button>

                    <button type="button" class="btn btn-danger btn-back" onclick="window.location.href='/usersList'">
                        Wróć
                    </button>

                </form>
            </section>
        </main>

    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>
<script>
    $(".submenu-adminpanel").addClass("show")
    $('.nav-item [href="/usersList"]').addClass("active");
</script>

</body>
</html>
