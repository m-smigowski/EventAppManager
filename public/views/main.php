<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Strona główna</title>
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
                <h1 class="h3">Strona Główna</h1>
                <div class="btn-toolbar mb-2 mb-md-0">

                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="coming-events">
                <h1 class="h6">Nadchodzące wydarzenia w których bierzesz udział</h1>
                <div id="event-1" class="table-responsive">
                    <table class="table table-striped table-sm">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tytuł</th>
                            <th scope="col">Opis</th>
                            <th scope="col">Status</th>
                            <th scope="col">Typ
                            </td>
                            <th scope="col">Data rozpoczęcia</th>
                            <th scope="col">Data zakończenia</th>
                            <th scope="col">Akcja</th>
                        </tr>
                        <?php if ($events === null) {
                            echo '
                                <tr><td></td><td>Obecnie nie jesteś dodany do żadnego wydarzenia. </td>
                                <td></td><td></td><td></td><td></td><td></td>
                                </tr>
                                </table>';
                        }
                        ?>

                        <?php if ($events !== null) foreach ($events as $event): ?>
                            <?php $lp++ ?>
                            <tr>
                                <td><?php echo $lp ?></td>
                                <td><?= $event->getTitle() ?></td>
                                <td><?= $event->getDescription() ?></td>
                                <td><?= $event->getStatus() ?></td>
                                <td><?= $event->getType() ?></td>
                                <td><?= date_format(date_create($event->getEventStart()), "H:i d/m/Y") ?></td>
                                <td><?= date_format(date_create($event->getEventEnd()), "H:i d/m/Y") ?></td>
                                <td>
                                    <a href="eventViewDetails?event_id=<?= $event->getId() ?>">
                                        <button type="button" class="btn-edit btn btn-primary btn-sm">Zobacz więcej
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </section>
            <section class="last-changes">
                <h1 class="h6"> Ostatnie zmiany w systemie:</h1>
                <table class="table table-striped table-sm">
                    <tr>
                        <th>Kto dokonał zmian</th>
                        <th>Co zrobił</th>
                        <th>Data</th>
                    </tr>
                    <?php
                    foreach ($events_logs as $event_log) {
                        echo "<tr>";
                        echo "<td>" . $event_log['name'] . " " . $event_log['surname'] . "</td>";
                        echo "<td>" . $event_log['log_content'] . "</td>";
                        echo "<td>" . $event_log['date'] . "</td>";
                        echo '</tr>';
                    }
                    ?>
                </table>
            </section>
        </main>


    </div>
</div>
<?php include 'public/views/elements/scripts.php' ?>
<script>$('.nav-item [href="/main"]').addClass("active");</script>

</body>
</html>
