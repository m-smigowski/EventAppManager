<?php
if ($_SESSION['user_status'] === 3) {
    $edit_event_details_button = '<button type="button" class="btn-edit btn btn-primary btn-sm">
        <a href="eventEdit?event_id=' . $event->getId() . '">Edytuj</a></button>';

    $edit_workers_button = '<button type = "button" class="btn-edit btn btn-primary btn-sm" >
                                    <a href = "eventEditWorkers?event_id=' . $event->getId() . '" > Edytuj</a></button>';

    $edit_equipment_button = '<button type="button" class="btn-edit btn btn-primary btn-sm" >
                                    <a href = "eventEditEquipment?event_id=' . $event->getId() . '" > Edytuj</a></button>';

    $edit_schedules_button = '<button type="button" class="btn-edit btn btn-primary btn-sm" >
                                    <a href = "eventEditSchedules?event_id=' . $event->getId() . '" > Edytuj</a></button>';
}


?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Szczegóły wydarzenia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="public/css/style.css" rel="stylesheet">

</head>
<body>
<?php include 'public/views/elements/header.php'; ?>
<div class="container-fluid">
    <?php include 'public/views/elements/nav.php' ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h3">Szczegóły wydarzenia</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group ">
                    <button type="button" class="btn btn-sm btn-outline-secondary"><a href="addEvent">Dodaj</a></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.reload()">Odśwież
                    </button>
                </div>
            </div>
        </div>

        <section class="events-container">
            <div class="row event-details-info">
                <div class="col event-details-left-side">
                    <p>Nazwa wydarzenia: <strong> <?= $event->getTitle() ?></strong></p>
                    <p>Opis: <strong><?= $event->getDescription() ?></strong></p>
                    <p>Status: <strong><?= $event->getStatus() ?></strong></p>
                    <p>Typ: <strong><?= $event->getType() ?></strong></p>
                    <p>Termin: <strong> <?= date_format(date_create($event->getEventStart()), "d/m/Y H:i") ?>
                            - <?= date_format(date_create($event->getEventEnd()), "d/m/Y H:i") ?></strong></p>
                    <p>Opiekun wydarzenia: <strong> <?php echo $user->getName() . " " . $user->getSurname(); ?></strong>
                    </p>
                    <p>Numer telefonu: <strong><?php echo $user->getPhone() ?></strong></p>
                    <?php echo $edit_event_details_button; ?>
                </div>

                <div class="col event-details-right-side">
                    <p>Miejsce wydarzenia: <strong><?= $event->getLocation() ?> </strong></p>
                    <p>Harmonogram pracy:</p>
                    <table class="table table-striped table-sm">
                        <tr>
                            <th class="col">Od</th>
                            <th class="col">Do</th>
                            <th class="col">Nazwa</th>
                            <th class="col">Opis</th>

                        </tr>

                        <?php foreach ($event_schedules

                        as $event_schedule): ?>
                        <tr>
                            <td><?= $event_schedule['start_date'] ?></td>
                            <td><?= $event_schedule['end_date'] ?></td>
                            <td><?= $event_schedule['title'] ?></td>
                            <td><?= $event_schedule['description'] ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </table>
                    <?php echo $edit_schedules_button ?>
                </div>

            </div>

            <div class="participants">
                <h1 class="h4">Pracownicy: </h1>
                <table class="table table-striped table-sm">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Imie</th>
                        <th scope="col">Nazwisko</th>
                        <th scope="col">Stanowisko</th>
                    </tr>
                    <?php
                    foreach ($usersInEvent as $userInEvent) {
                        if ($userInEvent->getName() === null) {
                            echo '
                                <tr>
                                <td></td>
                                <td>BRAK DODANYCH PRACOWNIKÓW</td>
                                <td></td>
                                <td></td></tr>
                                </table>';
                        } else {
                            $lp++;
                            echo '
                                <tr>
                                <td>' . $lp . '</td>
                                <td>' . $userInEvent->getName() . '</td>
                                <td>' . $userInEvent->getSurname() . '</td>
                                <td>' . $userInEvent->getRoleName() . '</td>
                                </tr>
                                ';

                        }
                    }
                    echo '</table>';
                    echo $edit_workers_button;
                    ?>
            </div>

            <div class="equipment mt-4">
                <h1 class="h4">Lista sprzętu:</h1>
                <table class="table table-sm table-striped">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Zdjęcie</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Kod produktu</th>
                        <th scope="col">Ilość</th>
                        <th scope="col">Uwagi</th>
                    </tr>
                    <?php foreach ($rented_items

                    as $rented_item): ?>
                    <tr>
                        <td><?= $rented_item['id'] ?></td>
                        <td><img width="80px" height="80px" src="public/img/uploads/<?= $rented_item['image'] ?> "</td>
                        <td><?= $rented_item['name'] ?></td>
                        <td><?= $rented_item['barcode'] ?></td>
                        <td><?= $rented_item['quantity'] ?></td>
                        <td><?= $rented_item['comments'] ?></td>
                        <?php endforeach; ?>
                    </tr>
                </table>
                <?php echo $edit_equipment_button ?>
            </div>

        </section>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $('.nav-item [href="/events"]').addClass("active");
    $(".nav-item [href='/pastEvents']").removeClass("hidden-link");
    $(".nav-item [href='/pastEvents']").addClass("show-link");
    $(".nav-item [href='/pastEvents']").attr("style", "color: #6c757d;");

</script>
</body>
</html>

