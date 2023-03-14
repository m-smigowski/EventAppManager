<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Dodawanie pracowników do wydarzeń<</title>
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>

<?php include 'public/views/elements/header.php';?>
<?php include 'public/views/elements/modal.php';?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php'?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Dodawanie pracowników do wydarzeń</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="events-edit">
                <div class="events">
                    <div id="event-1" class="table-responsive">
                        <table class="table table-striped table-sm">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Imie</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">Stanowisko pracy</th>
                                <th scope="col">akcja</th>
                            </tr>
                            <?php
                            foreach ($usersInEvent

                            as $userInEvent): ?>
                            <?php $lp++ ?>
                            <tr>
                                <td><?php echo $lp ?></td>
                                <td><?= $userInEvent->getName() ?></td>
                                <td><?= $userInEvent->getSurname() ?></td>
                                <td><?= $userInEvent->getRoleName() ?></td>
                                <td>
                                    <a href="eventEditWorkers?event_id=<?php echo $event_id ?>&name=<?= $userInEvent->getName()
                                    ?>&surname=<?= $userInEvent->getSurname() ?>&role_name=<?= $userInEvent->getRoleName() ?>">
                                        <button type="button" class="btn-edit btn btn-primary btn-sm">Usuń</button>
                                    </a>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                    </div>

                    <form action="eventEditWorkers?event_id=<?php echo $event_id ?>" method="POST"
                          ENCTYPE="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <label>Pracownik:</label>
                                <select name="user_name_and_surname" class="form-control">
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['name']; ?> <?= $user['surname'] ?> <?= $user['id'] ?>"><?= $user['name']; ?> <?= $user['surname'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label>Stanowisko pracy:</label>
                                <select name="user_role" class="form-control">
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['role_name']; ?>"><?= $role['role_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-success mt-2" value="Zaktualizuj">Dodaj</button>
                        <button type="button" class="btn btn-primary mt-2" onclick="window.location.href='/eventViewDetails?event_id=<?php echo $event_id ?>'">Wróć</button>
                    </form>


                </div>
            </section>
        </main>
    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>

</body>
</html>
