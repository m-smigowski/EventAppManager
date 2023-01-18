<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Strona główna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="public/css/style.css" rel="stylesheet">

</head>
<body>
<?php include 'public/views/elements/header.php';?>
<div class="container-fluid">
    <div class="row">

        <?php include 'public/views/elements/nav.php' ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h6">Zmiana danych</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group ">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick = "location.reload()">Odśwież</button>
                    </div>
                </div>
            </div>

            <section class="user-edit">
                <form action="userUpdate" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-outline mb-2">
                        <input name="email" type="text"  class="form-control" value="<?= $user->getEmail();?>" />
                        <label class="form-label"> Adres E-Mail</label>
                    </div>

                    <div class="form-outline mb-2">
                        <input name="name" type="text"  class="form-control" value="<?= $user->getName();?>" />
                        <label class="form-label" >Imię</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="surname" type="text"  class="form-control" value="<?= $user->getSurname();?>" />
                        <label class="form-label" ">Nazwisko</label>
                    </div>
                    <div class="form-outline mb-2">
                        <input name="phone" type="text"  class="form-control" value="<?= $user->getPhone();?>" />
                        <label class="form-label">Telefon</label>
                    </div>

                    <input name="id" type="hidden" value="<?=$_SESSION['user_id'];?>"></input>

                    <button type="submit" class="btn btn-success" value="Zaktualizuj" name="UserUP" >Zaktualizuj</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='/usersPanel'">Wróć</button>
                </form>
            </section>


        </main>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="public/js/script.js"></script>
    <script>$('.nav-item [href="/usersPanel"]').addClass("active");</script>
</body>
</html>
