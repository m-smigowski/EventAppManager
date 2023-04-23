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
<?php include 'public/views/elements/modal.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Panel Użytkownika</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="user-edit d-flex ">
                <div class="user-data box w-50  me-2">
                    <h1 class="h4 mb-4">Edycja danych</h1>
                    <form class="w-75" action="userUpdate" method="POST" ENCTYPE="multipart/form-data">
                        <div class="form-outline mb-2">
                            <label> Adres E-Mail</label>
                            <input name="email" type="text" class="form-control" disabled
                                   value="<?= $user->getEmail(); ?>"/>
                        </div>

                        <div class="form-outline mb-2">
                            <label>Imię</label>
                            <input name="name" type="text" class="form-control" disabled
                                   value="<?= $user->getName(); ?>"/>
                        </div>
                        <div class="form-outline mb-2">
                            <label>Nazwisko</label>
                            <input name="surname" type="text" class="form-control" disabled
                                   value="<?= $user->getSurname(); ?>"/>
                        </div>
                        <div class="form-outline mb-2">
                            <label>Telefon</label>
                            <input name="phone" type="text" class="form-control" disabled
                                   value="<?= $user->getPhone(); ?>"/>
                        </div>

                        <input name="id" type="hidden" value="<?= $_SESSION['user_id']; ?>">


                        <button type="button" class="btn btn-warning btn-edit" onclick="editForm()">
                            Edytuj
                        </button>


                        <button type="submit" class="btn btn-success btn-up d-none" value="Zaktualizuj" name="UserUP">
                            Zaktualizuj
                        </button>

                        <button type="button" class="btn btn-danger btn-back d-none"
                                onclick="window.location.href='/userEdit'">
                            Wróć
                        </button>


                    </form>
                </div>

                <div class="user-profile-photo box h-50">
                    <h1 class="h4 mb-4">Zmiana zdjęcia profilowego</h1>
                    <div class="d-flex">
                        <img width="150" height="150"
                             src="public/img/app-image/<?= $_SESSION['user_profile_photo']; ?>">
                        <form class="ms-2" action="userUpdatePhoto" method="POST" ENCTYPE="multipart/form-data">
                            <div class="form-group">
                                <label for="image">Wgraj nowe zdjęcie profilowe</label>
                                <input name="profile_image" type="file" class="form-control mt-2">
                            </div>
                            <input name="old_photo" type="hidden" class="form-control"
                                   value="<?= $_SESSION['user_profile_photo'] ?>">
                            <button type="submit" class="col btn btn-success mt-2" value="Update">Zaktualizuj</button>
                        </form>
                    </div>
                </div>

            </section>
        </main>
    </div>
</div>


<?php include 'public/views/elements/scripts.php' ?>
<script>
    $(".submenu-userpanel").addClass("show")
    $('.nav-item [href="/userEdit"]').addClass("active");

    function editForm() {
        $(':input').prop("disabled", false);
        $('.btn-edit').css("display", "none");
        $('.btn-up').removeClass('d-none');
        $('.btn-back').removeClass('d-none');
    }

</script>

</body>
</html>
