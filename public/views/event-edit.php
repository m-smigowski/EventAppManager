<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Edycja wydarzeń</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="public/css/style.css" rel="stylesheet">

</head>
<body>

<?php include 'public/views/elements/header.php';?>

<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php'?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Edycja wydarzeń</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group ">
                        <button type="button" class="btn btn-sm btn-outline-secondary"><a href="addEvent">Dodaj</a></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick = "location.reload()">Odśwież</button>
                    </div>
                </div>
            </div>

            <section class="events-edit">
                <form action="updateEvent" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input name="title" type="text" class="form-control" value="<?= $event->getTitle()?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Opis wydarzenia</label>
                        <textarea name="description" class="form-control"  rows="3"><?= $event->getDescription()?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input name="status"type="text" class="form-control"  value="<?= $event->getStatus()?>">
                    </div>
                    <div class="form-group">
                        <label for="event_Type">Typ wydarzenia</label>
                        <input name="type" type="text" class="form-control"  value="<?= $event->getType()?>">
                    </div>
                    <div class="form-group">
                        <label for="event_Date">Data</label>
                        <input name="event_date" type="date" class="form-control" value="<?= $event->getEventDate()?>">
                    </div>

                    <input name="event_id" type="hidden" value="<?= $event->getID()?>">
                    <input name="assigned_by_id" type="hidden" value="<?= $event->getIdAssignedBy()?>">


                    <button type="submit" class="btn btn-success" value="Zaktualizuj" name="EventUP" >Zaktualizuj</button>
                    <button type="submit" class="btn btn-danger" value="Usuń" name="EventDEL" >Usuń</button>

                </form>

            </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</body>
</html>
