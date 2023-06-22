<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Edytowanie Spotkania</title>
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
                <h1 class="h4">Edytowanie spotkania</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="add-user-meeting mb-2">
                <form name="event-form" class="w-75 box" action="addUserMeetings" method="POST"
                      ENCTYPE="multipart/form-data">
                    <div class="current_workers">

                    </div>
                    <div class="form-group">
                        <label for="client_id">Pracownicy dodani do spotkania</label>
                        <table class="table table-striped table-sm">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Imie</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">akcja</th>
                            </tr>

                            <?php foreach ($users_in_meeting as $user_in_meeting): ?>
                            <?php $lp++ ?>
                            <tr>
                                <td><?php echo $lp ?></td>
                                <td><?= $user_in_meeting['name'] ?></td>
                                <td><?= $user_in_meeting['surname'] ?></td>
                                <td>
                                    <a href="dropUserMeetings?meeting_id=<?php echo $_GET['meeting_id']?>&user_id=<?= $user_in_meeting['id'] ?>"
                                    <button type="button" class="btn-edit btn btn-danger btn-sm">Usuń</button>
                                    </a>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                        <label for="user_id">Dodaj pracowników</label>
                        <select name="user_id" type="text" class="form-select" required>
                            <?php foreach ($all_active_users as $all_active_user): ?>
                                <option value="<?= $all_active_user['id']?>"> <?= $all_active_user['name']?>
                                    <?= $all_active_user['surname']?>
                                </option>
                            <? endforeach; ?>

                        </select>
                        <input type="hidden" name="meeting_id" value="<?php echo $_GET['meeting_id']?>">
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Dodaj</button>
                </form>
            </section>


            <section class="update-meeting">
                <form name="event-form" class="w-75 box" action="updateMeeting" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label for="client_id">Klient</label>
                        <select name="client_id" type="text" class="form-select" required>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client->getId() ?>"> <?= $client->getCompanyName() ?>
                                    (<?= $client->getName() ?> <?= $client->getSurname() ?>)
                                </option>
                            <? endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="topic">Temat</label>
                        <input name="topic" type="text" class="form-control" value="<?= $meeting->getTopic() ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="date">Data spotkania</label>
                        <input name="date" type="datetime-local" class="form-control" value="<?= $meeting->getDate() ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="location">Lokalizacja spotkania</label>
                        <input name="location" type="text" class="form-control" value="<?= $meeting->getLocation() ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="tasks">Zadania</label>
                        <textarea name="tasks" class="form-control" required><?= $meeting->getTasks() ?></textarea>
                    </div>

                    <input type="hidden" name="meeting_id" value="<?= $meeting->getId() ?>">

                    <button type="submit" class="btn btn-success mt-2">Zaktualizuj</button>
                    <input class="btn btn-primary mt-2" type="reset" value="Reset">

                </form>




    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>
<script type="text/javascript" src="./public/js/event-valid.js" defer></script>
<script>
    $(".submenu-meetings").addClass("show");
    $('.nav-link[href="/meetings"]').addClass("active");
</script>
</body>
</html>
