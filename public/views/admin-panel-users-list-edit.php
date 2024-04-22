<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Edycja użytkownika</title>
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
                <h1 class="h3">Edycja użytkownika</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addEvent">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="users-list-edit">
                <form class="register w-75 box" action="usersListEdit" method="POST">
                    <div class="form-outline mb-2">
                        <input name="name" type="text" class="form-control" value="<?= $user[0]["name"] ?>" required/>
                        <label class="form-label">Imię</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="surname" type="text" class="form-control" value="<?= $user[0]["surname"] ?>"
                               required/>
                        <label class="form-label" ">Nazwisko</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="email" type="email" class="form-control" value="<?= $user[0]["email"] ?>"
                               required/>
                        <label class="form-label">Adres E-Mail</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="phone" type="number" class="form-control" value="<?= $user[0]["phone"] ?>"
                               required/>
                        <label class="form-label">Telefon</label>
                    </div>
                    <div class="form-outline mb-2">
                        <select name="status" type="text" class="form-control" required/>
                        <?php
                        if ($user[0]["status"] === 1) {
                            echo "
                            <option value='1'>Użytkownik</option>
                            <option value='2'>Moderator</option>
                            <option value='3'>Administator</option>
                            ";
                        }
                        if ($user[0]["status"] === 2) {
                            echo "
                            <option value='2'>Moderator</option>  
                            <option value='1'>Użytkownik</option>
                            <option value='3'>Administator</option>
                            ";
                        }
                        if ($user[0]["status"] === 3) {
                            echo "
                            <option value='1'>Administator</option>
                            <option value='2'>Moderator</option>  
                            <option value='3'>Użytkownik</option>
                            ";
                        }
                        ?>

                        </select>
                        <label class="form-label">Rola</label>

                    </div>
                    <div class="form-outline mb-2">
                        <select name="active" type="text" class="form-control" required/>
                        <?php
                        if ($user[0]["active"] === 0) {
                            echo "
                            <option value='0'>Nieaktywny</option>
                            <option value='1'>Aktywny</option>
                            <option value='2'>Zablokowany</option>
                            ";
                        }
                        if ($user[0]["active"] === 1) {
                            echo "
                            <option value='1'>Aktywny</option>
                            <option value='0'>Nieaktywny</option>
                            <option value='2'>Zablokowany</option>
                            ";
                        }
                        if ($user[0]["active"] === 2) {
                            echo "
                            <option value='2'>Zablokowany</option>
                            <option value='1'>Aktywny</option>
                            <option value='0'>Nieaktywny</option>                           
                            ";
                        }
                        ?>

                        </select>
                        <label class="form-label">Status</label>
                    </div>

                    <input type="hidden" name="id" value="<?= $user[0]["id"] ?>">
                    <input type="hidden" name="id_user_det" value="<?= $user[0]["id_user_details"] ?>">
                    <div class="d-flex">
                        <button type="submit" class="btn btn-success me-2" name="Update">
                            Zaktualizuj
                        </button>
                        <button type="button" class="btn btn-primary" onclick="window.location.href='/usersList'">
                            Wróć
                        </button>
                        <button type="submit" class="btn-drop btn btn-danger" name="Drop">
                            Usuń użytkownika
                        </button>
                    </div>


            </section>
        </main>

    </div>
</div>


<?php include 'public/views/elements/scripts.php' ?>
<script>
    $(".submenu-adminpanel").addClass("show")
    $('.nav-item [href="/usersList"]').addClass("active");
</script

</body>
</html>