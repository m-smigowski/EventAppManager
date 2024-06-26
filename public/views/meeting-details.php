<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Spotkania</title>
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
                <h1 class="h3">Spotkanie na temat: <?= $meeting->getTopic() ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>
            <section>
                <div class="row meeting-details-info mb-3 box w-75">
                    <div class="col">
                        <p>Temat spotkania: <strong><?= $meeting->getTopic() ?></strong></p>
                        <p>Klient:
                            <?php
                            $client_details = $meeting->getClient();
                            foreach ($client_details as $client_detail) {
                                echo '<strong>'.$client_detail['company_name'] .'</strong>'. ' (' . $client_detail['name'] . ' ' . $client_detail['surname'] .')</p>';
                                echo '<p>Numer telefonu klienta: <strong>'.$client_detail['phone'].'</strong></p>';
                            }
                            ?>
                        <p>Data spotkania: <strong><?= $meeting->getDate() ?></strong></p>
                        <p>Lokalizacja: <strong><?= $meeting->getLocation() ?></strong></p>
                        <p>Pracownicy biorący udział:
                            <?php
                            if($users_in_meeting != NULL){
                                foreach ($users_in_meeting as $user_in_meeting){
                                    echo '<strong>'.$user_in_meeting['name'].' '.$user_in_meeting['surname'].'</strong>, ';
                                }
                            }else echo '<strong>Brak pracowników dodanych do spotkania</strong>';
                            ?>
                        </p>
                        <p>Zadania: <strong><?= $meeting->getTasks() ?></strong></p>
                        <?php
                        if ($_SESSION['user_status'] === 2 || $_SESSION['user_status'] === 3) {
                        echo '<a href="editMeeting?meeting_id='.$_GET['meeting_id'].'">
                        <button type="button" class="btn btn-warning btn-sm col-md-2 ms-auto">
                        Edytuj</button></a>';}
                        ?>
                    </div>
                </div>
            </section>
    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>

<script type="text/javascript" src="./public/js/search.js"></script>
<script>
    $(".submenu-meetings").addClass("show");
    $('.nav-link[href="/meetings"]').addClass("active");
</script>

</body>

<template id="event-template">
    <tr>
        <td class="event-id table-light"></td>
        <td class="event-title table-light"></td>
        <td class="event-desc table-light"></td>
        <td class="event-status table-light"></td>
        <td class="event-type table-light"></td>
        <td class="event-start table-light"></td>
        <td class="event-end table-light"></td>
        <td class="btn-more table-light"></td>
    </tr>
</template>
</html>
