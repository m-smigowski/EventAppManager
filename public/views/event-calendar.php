<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Kalendarz</title>
    <link href="public/css/calendar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>

<?php include 'public/views/elements/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Kalendarz</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>
            <section name="calendar">
                <div class="row">
                    <div class="col-5 wrapper">
                        <header>
                            <p class="current-date"></p>
                            <div class="icons">
                                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                                <span id="next" class="material-symbols-rounded">chevron_right</span>
                            </div>
                        </header>
                        <div class="calendar">
                            <ul class="weeks">
                                <li>Niedz</li>
                                <li>Pon</li>
                                <li>Wt</li>
                                <li>Śr</li>
                                <li>Czw</li>
                                <li>PT</li>
                                <li>Sob</li>
                            </ul>
                            <ul class="days"></ul>
                        </div>
                    </div>

                    <div class="col eventsList">
                        <div class="table-responsive">
                            <h1 class="h4 event-date"></h1>
                            <table class="table table-hover table align-middle">
                                <thead class="table-header table-secondary table align-middle">
                                <tr>
                                    <th scope="col">Tytuł</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Data rozpoczęcia</th>
                                    <th scope="col">Data zakończenia</th>
                                    <th scope="col">Akcja</th>
                                </tr>
                                </thead>
                                <tbody class="events">
                                </tbody>
                            </table>

                    </div>
                </div>
            </section>
    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>

<script type="text/javascript" src="./public/js/calendar.js"></script>
</body>

<template id="event-template">
    <tr>
        <td class="event-title"></td>
        <td class="event-desc"></td>
        <td class="event-status"></td>
        <td class="event-start"></td>
        <td class="event-end"></td>
        <td class="btn-place"></td>
    </tr>
</template>
</html>
