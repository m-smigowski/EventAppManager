<?php
if ($_SESSION['user_status'] === 2 || $_SESSION['user_status'] === 3) {
    $edit_event_details_button = '<a href="eventEdit?event_id=' . $event->getId().'">
        <button type="button" class="btn-edit btn btn-primary btn-sm col-md-2">
        Edytuj</button></a>';

    $edit_workers_button = ' <a href = "eventEditWorkers?event_id=' . $event->getId().'">
            <button type="button" class="btn-edit btn btn-primary btn-sm col-md-2" >Edytuj</button></a>';

    $edit_equipment_button = '<a href = "eventEditEquipment?event_id=' . $event->getId().'"><button type="button" class="btn-edit btn btn-primary btn-sm col-md-1" >
                                     Edytuj</button></a>';

    $edit_schedules_button = '<a href = "eventEditSchedules?event_id=' . $event->getId().'"><button type="button" class="btn-edit btn btn-primary btn-sm col-md-2" >
                                     Edytuj</button></a>';
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Szczegóły wydarzenia</title>
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>

<?php include 'public/views/elements/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h4"><?= $event->getTitle() ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addEvent">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="events-container">
                <div class="row event-details-info mb-3 box">
                    <div class="col event-details-left-side">
                        <h1 class="h6">Szczegóły wydarzenia:</h1>
                        <p>Nazwa wydarzenia: <strong> <?= $event->getTitle() ?></strong></p>
                        <p>Opis: <strong><?= $event->getDescription() ?></strong></p>
                        <p>Status: <strong><?= $event->getStatus() ?></strong></p>
                        <p>Typ: <strong><?= $event->getType() ?></strong></p>
                        <p>Termin: <strong> <?= date_format(date_create($event->getEventStart()), "d/m/Y H:i") ?>
                                - <?= date_format(date_create($event->getEventEnd()), "d/m/Y H:i") ?></strong></p>
                        <p>Opiekun wydarzenia:
                            <strong> <?php echo $user->getName() . " " . $user->getSurname(); ?></strong>
                        </p>
                        <p>Numer telefonu: <strong><?php echo $user->getPhone() ?></strong></p>
                        <?php echo $edit_event_details_button; ?>
                    </div>

                    <div class="col event-details-right-side ">
                        <p>Miejsce wydarzenia: <strong><?= $event->getLocation() ?> </strong></p>
                        <p>Harmonogram pracy:</p>
                        <table class="table table-striped table-sm box">
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
                <div class="row">
                    <div class="col participants mb-3 me-2 box">
                        <h1 class="h4">Pracownicy: </h1>
                        <table class="table table-striped table-sm box">
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

                    <div class="col user-task mb-3 box">
                        Twoje zdania:
                    </div>
                </div>
                <div class="row equipment box">
                    <h1 class="h4">Lista sprzętu:</h1>
                    <table class="table table-sm table-striped box">
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
                            <td><img width="80px" height="80px" src="public/img/uploads/<?= $rented_item['image'] ?> "
                            </td>
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
</div>

<?php include 'public/views/elements/scripts.php' ?>

</body>
</html>

