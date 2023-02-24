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
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Edycja pracowników przypisanych do wydarzenia</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group ">
                        <button type="button" class="btn btn-sm btn-outline-secondary"><a href="addEvent">Dodaj</a></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick = "location.reload()">Odśwież</button>
                    </div>
                </div>
            </div>

            <section class="events-edit">
                <div class="events">
                    <div id="event-1" class="table-responsive">
                        <table class="table table-striped table-sm">
                            <tr>
                                <th scope="col">Od</th>
                                <th scope="col">Do</th>
                                <th scope="col">Tytuł</th>
                                <th scope="col">Opis pracy</th>
                                <th scope="col">Akcja</th>
                            </tr>
                            <?php
                            foreach ($event_schedules as $event_schedule): ?>
                                <tr>
                                        <td><?= $event_schedule['start_date']?></td>
                                        <td><?= $event_schedule['end_date']?></td>
                                        <td><?= $event_schedule['title']?></td>
                                        <td><?= $event_schedule['description']?></td>
                                    <td><button type="button" class="btn-edit btn btn-primary btn-sm">
                                    <a href="eventEditSchedules?event_id=<?php echo $_GET['event_id']?>&event_schedule_id=<?= $event_schedule['id']?>">
                                        Usuń</a></button></td>
                                    <?php endforeach;?>
                                </tr>
                        </table>
                    </div>

                        <form action="eventEditSchedules?event_id=<?=$event->getId()?>" method="POST" ENCTYPE="multipart/form-data">
                            <div class="row">
                                <div class="col form-group">
                                    <label name="start_date">Czas od</label>
                                    <input name="start_date" type="datetime-local" class="form-control" value="<?= $event->getEventStart()?>">
                                </div>

                                <div class="col form-group">
                                    <label name="end_date">Czas do</label>
                                    <input name="end_date" type="datetime-local" class="form-control" value="<?= $event->getEventEnd()?>">
                                </div>

                                <div class="col form-group">
                                    <label name="title">Tytuł</label>
                                    <textarea name="title" type="text" class="form-control"></textarea>
                                </div>

                                <input name="event_id" type="hidden" value="<?=$event->getId()?>">
                                <div class="col form-group">
                                    <label name="title">Opis pracy</label>
                                    <textarea name="description" type="text" class="form-control"></textarea>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success" value="Zaktualizuj">Dodaj</button>
                            <button class="btn btn-danger"><a href="eventViewDetails?event_id=<?=$event->getId()?>">Wróć</a></button>

                        </form>

                </div>
            </section>
        </main>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</body>
</html>
