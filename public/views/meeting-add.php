<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Dodawanie Spotkania</title>
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
                <h1 class="h4">Dodawanie Spotkania</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="add-meeting">
                <form name="event-form" class="w-75 box" action="addMeeting" method="POST"
                      onsubmit="return validateEventForm()" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label for="client_id">Klient</label>
                        <select name="client_id" type="text" class="form-select" required>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?=$client->getId()?>"> <?=$client->getCompanyName()?> (<?=$client->getName()?> <?=$client->getSurname()?>)</option>
                            <?endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="topic">Temat</label>
                        <input name="topic" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Data spotkania</label>
                        <input name="date" type="datetime-local" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Lokalizacja spotkania</label>
                        <input name="location" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="tasks">Zadania</label>
                        <textarea name="tasks" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success mt-2">Dodaj</button>
                    <input class="btn btn-primary mt-2" type="reset" value="Reset">

                </form>

            </section>
            <div id="demo">
            </div>

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
