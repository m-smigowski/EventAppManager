<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Edytowanie klienta</title>
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
                <h1 class="h3">Edytowanie klienta</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="client-list-add">
                <form class=" w-75 box" action="editClient" method="POST">
                    <div class="form-outline mb-2">
                        <label class="form-label">Nazwa firmy</label>
                        <input name="company_name" type="text" class="form-control" value="<?=$client->getCompanyName()?>" required />
                    </div>
                    <div class="form-outline mb-2">
                        <label class="form-label">Imie</label>
                        <input name="name" type="text" class="form-control" value="<?=$client->getName()?>" required/>
                    </div>
                    <div class="form-outline mb-2">
                        <label class="form-label">Nazwisko</label>
                        <input name="surname" type="text" class="form-control" value="<?=$client->getSurname()?>" required/>
                    </div>

                    <div class="form-outline mb-2">
                        <label class="form-label">Adres E-Mail</label>
                        <input name="email" type="email" class="form-control" value="<?=$client->getEmail()?>" required/>
                    </div>
                    <div class="form-outline mb-2">
                        <label class="form-label">Telefon</label>
                        <input name="phone" type="tel" pattern="(?:(?:(?:\+|00)?48)|(?:\(\+?48\)))?(?:1[2-8]|2[2-69]|3[2-49]|4[1-8]|5[0-9]|6[0-35-9]|[7-8][1-9]|9[145])\d{7}" class="form-control" value="<?=$client->getPhone()?>"required/>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Dodatkowe informacje</label>
                        <textarea name="description" class="form-control" required><?=$client->getCompanyName()?></textarea>
                    </div>

                    <input name="client_id" type="hidden" value="<?=$client->getId() ?>">

                    <div class="d-flex">
                        <button type="submit" class="btn btn-success me-2" name="updateClient">
                            Zaktualizuj
                        </button>
                        <button type="button" class="btn btn-primary" onclick="window.location.href='/clientsList'">
                            Wróć
                        </button>
                        <button type="submit" class="btn btn-danger ms-auto" name="dropClient">Usuń klienta</button>
                    </div>


            </section>
        </main>

    </div>
</div>


<?php include 'public/views/elements/scripts.php' ?>
<script>
    $(".submenu-adminpanel").addClass("show")
    $('.nav-item [href="/clientsList"]').addClass("active");
</script>


</body>
</html>