<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Edycja wydarzeń</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="public/css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'public/views/elements/header.php';?>
<?php include 'public/views/elements/modal.php';?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php'?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h5">Edycja wydarzeń</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="event-edit w-75">
                <form name="event-form" onsubmit="" action="updateEvent" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input name="title" type="text" class="form-control" value="<?= $event->getTitle()?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Opis wydarzenia</label>
                        <textarea name="description" class="form-control"  rows="3" required><?= $event->getDescription()?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" type="text"  class="form-control" required value="<?=$event->getStatus();?>">
                            <option>Potwierdzone</option>
                            <option>Niepotwierdzone</option>
                            <option>Odwołane</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="event_Type">Typ wydarzenia</label>
                        <input name="type" type="text" class="form-control" value="<?= $event->getType()?>" required>
                    </div>
                    <div class="form-group">
                        <label for="event_start">Data startu</label>
                        <input name="event_start" type="datetime-local" class="form-control" value="<?= $event->getEventStart()?>"required>
                    </div>
                    <div class="form-group">
                        <label for="event_end">Data zakończenia</label>
                        <input name="event_end" type="datetime-local" class="form-control" value="<?= $event->getEventEnd()?>"required>
                    </div>
                    <div class="form-group">
                        <label for="location">Lokalizacja wydarzenia</label>
                        <input name="location" type="text" class="form-control" value="<?= $event->getLocation()?>">
                    </div>

                    <input name="event_id" type="hidden" value="<?= $event->getID()?>">
                    <input name="assigned_by_id" type="hidden" value="<?= $event->getIdAssignedBy()?>">

                    <button type="submit" class="btn btn-success mt-2 mb-2" name="update">Zaktualizuj</button>
                    <button type="button" class="btn btn-primary mt-2 mb-2"" onclick="window.location.href='/eventViewDetails?event_id=<?=$event->getID()?>'">Wróć</button>
                    <button type="submit" class="btn btn-danger mt-2 mb-2"" name="drop">Usuń</button>
                </form>

            </section>
    </div>
    <script type="text/javascript" src="./public/js/event-valid.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $('.nav-link[href="/events"]').addClass("active");
    </script>

</body>
</html>
