<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Lista klientów</title>
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
                <h1 class="h3">Lista Klientów</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addClient">
                        <button type="button" class="btn btn-primary me-2">Dodaj klienta</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="users-list">
                <div class="table-responsive rounded-2">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark table align-middle">
                        <tr>
                            <th scope="col">Nazwa firmy</th>
                            <th scope="col">Imię</th>
                            <th scope="col">Nazwisko</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Opis</th>
                            <th scope="col">Akcja</th>
                        </tr>
                        </thead>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td class="table-light"><?= $client->getCompanyName() ?></td>
                                <td class="table-light"><?= $client->getName() ?></td>
                                <td class="table-light"><?= $client->getSurname() ?></td>
                                <td class="table-light"><?= $client->getPhone() ?></td>
                                <td class="table-light"><?= $client->getEmail() ?></td>
                                <td class="table-light"><?= $client->getDescription() ?></td>
                                <td class="table-light">
                                    <a href="editClient?client_id=<?= $client->getId() ?>">
                                        <button type="button" class="btn-edit btn btn-primary btn-sm ">Edytuj
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </table>
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
