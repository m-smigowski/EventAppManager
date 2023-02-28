<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Dodawanie wydarzeń</title>
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
                <h1 class="h3">Dodawanie wydarzeń</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addEvent">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="add-event">
                <form name="event-form" class="w-75" action="addEvent" method="POST" onsubmit="return validateEventForm()" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input name="title" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Opis wydarzenia</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" type="text"  class="form-control"required>
                            <option>Potwierdzone</option>
                            <option>Niepotwierdzone</option>
                            <option>Odwołane</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="event_type">Typ wydarzenia</label>
                        <input name="type" type="text"  class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="event_start">Data startu</label>
                        <input name="event_start" type="datetime-local" class="form-control" required >
                    </div>
                    <div class="form-group">
                        <label for="event_end">Data zakończenia</label>
                        <input name="event_end" type="datetime-local" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Lokalizacja wydarzenia</label>
                        <input name="location" type="text" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Dodaj</button>
                    <input class="btn btn-primary mt-2" type="reset" value="Reset">

                </form>

            </section>
        <div id="demo"></div>
    </div>
    <script type="text/javascript" src="./public/js/event-valid.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>$('.nav-item [href="/events"]').addClass("active");</script>
</body>
</html>
