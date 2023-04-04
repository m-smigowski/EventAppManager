<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Zmiana danych użytkownika</title>
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>
<?php include 'public/views/elements/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Zmiana danych użytkownika</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="user-edit">
                <div class="user-profile-photo">
                    <img width="150" height="150" src="public/img/app-image/<?=$_SESSION['user_profile_photo'];?>">
                    <form class="w-75" action="userUpdatePhoto" method="POST" ENCTYPE="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Wgraj nowe zdjęcie profilowe</label>
                            <input name="image" type="file" class="form-control">
                            <button type="submit" class="btn btn-success" value="Update">Zaktualizuj</button>
                        </div>
                    </form>
                </div>
                <br><br>
                <form class="w-75" action="userUpdate" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-outline mb-2">
                        <input name="email" type="text" class="form-control" value="<?= $user->getEmail(); ?>"/>
                        <label class="form-label"> Adres E-Mail</label>
                    </div>

                    <div class="form-outline mb-2">
                        <input name="name" type="text" class="form-control" value="<?= $user->getName(); ?>"/>
                        <label class="form-label">Imię</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="surname" type="text" class="form-control"  value="<?= $user->getSurname(); ?>"/>
                        <label class="form-label" ">Nazwisko</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="phone" type="text" class="form-control" value="<?= $user->getPhone(); ?>"/>
                        <label class="form-label">Telefon</label>
                    </div>

                    <input name="id" type="hidden" value="<?= $_SESSION['user_id']; ?>">

                    <button type="submit" class="btn btn-success" value="Zaktualizuj" name="UserUP">Zaktualizuj</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='/usersPanel'">Wróć
                    </button>
                </form>
            </section>


        </main>
    </div>
</div>


<?php include 'public/views/elements/scripts.php' ?>
<script>$('.nav-item [href="/usersPanel"]').addClass("active");</script>

</body>
</html>
