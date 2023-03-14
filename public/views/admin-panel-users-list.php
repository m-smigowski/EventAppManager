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
                <h1 class="h2">Lista użytkowników aplikacji</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="register">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="users-list">
                <table class="table table-hover table align-middle">
                    <thead class="table-secondary table align-middle">
                    <th scope="col">Imię</th>
                    <th scope="col">Nazwisko</th>
                    <th scope="col">E-Mail</th>
                    <th scope="col">Numer telefonu</th>
                    <th scope="col">Rola
                    </td>
                    <th scope="col">Status
                    </td>
                    <th scope="col">Ostatnie logowanie</th>
                    <th scope="col">Adres Ip</th>
                    <th scope="col">Akcja</th>
                    </tr>
                    </thead>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['surname'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['phone'] ?></td>
                            <td>
                                <?php
                                if ($user['status'] === 1) echo 'Użytkownik';
                                if ($user['status'] === 2) echo 'Moderator';
                                if ($user['status'] === 3) echo 'Administator';
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($user['active'] === 0) echo 'Nieaktywny';
                                if ($user['active'] === 1) echo 'Aktywny';
                                if ($user['active'] === 2) echo 'Zablokowany';
                                ?>
                            </td>
                            </td>
                            <td><?= $user['last_login'] ?></td>
                            <td><?= $user['ip_address'] ?></td>
                            <td>
                                <a href="usersListEdit?user_id=<?= $user['id'] ?>">
                                    <button type="button" class="btn-edit btn btn-primary btn-sm">Edytuj</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>

            </section>
        </main>

    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>
<script>$('.nav-item [href="/adminPanel"]').addClass("active");</script>

</body>
</html>
