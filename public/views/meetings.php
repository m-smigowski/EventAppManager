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
<?php $search = '<input type="search" id="search-input" class="form-control form-control-dark text-bg-dark w-25 me-auto" placeholder="Szukaj....."
           aria-label="Search">'; ?>
<?php include 'public/views/elements/header.php'; ?>
<?php include 'public/views/elements/modal.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3"><?= $title ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addMeeting">
                        <button type="button" class="btn btn-primary me-2">Dodaj Spotkanie</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>
            <section>
                <div class="table-responsive rounded-2">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark table align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Klient</th>
                            <th scope="col">Temat</th>
                            <th scope="col">Data</th>
                            <th scope="col">Lokalizacja</th>
                            <th scope="col">Akcja</th>
                        </tr>
                        </thead>
                        <tbody class="events">
                        <?php foreach ($meetings as $meeting): ?>
                            <?php $lp++ ?>
                            <tr>
                                <td class="table-light"><?php echo $lp ?></td>
                                <td class="table-light">
                                    <?php
                                    $client_details = $meeting->getClient();
                                    foreach ($client_details as $client_detail) {
                                        echo $client_detail['company_name'] . ' (' . $client_detail['name'] . ' ' . $client_detail['surname'] . ')';
                                    }
                                    ?>
                                </td>

                                <td class="table-light"><?= $meeting->getTopic() ?></td>
                                <td class="table-light"><?= date_format(date_create($meeting->getDate()), "H:i d/m/Y") ?></td>
                                <td class="table-light"><?= $meeting->getLocation() ?></td>
                                <td class="table-light">
                                    <a href="meetingDetails?meeting_id=<?= $meeting->getId() ?>">
                                        <button type="button" class="btn-edit btn btn-primary btn-sm ">Zobacz więcej
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
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
