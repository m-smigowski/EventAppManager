<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Szczegóły wydarzenia</title>
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
                <h1 class="h3">Szczegóły wydarzenia</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group ">
                        <button type="button" class="btn btn-sm btn-outline-secondary"><a href="addEvent">Dodaj</a></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick = "location.reload()">Odśwież</button>
                    </div>
                </div>
            </div>

            <section class="events-container">
                <div class="row">
                <div class="col event-details-info">
                    <h3>Informacje o wydarzeniu</h3>
                    <p>Nazwa wydarzenia: <?= $event->getTitle()?></p>
                    <p>Opis:<?= $event->getDescription()?></p>
                    <p>Status:<?= $event->getStatus()?></p>
                    <p>Typ:<?= $event->getType()?></p>
                    <p>Data wydarzenia: <?= $event->getEventDate()?></p>
                    <?php
                    if($_SESSION['user_status']===3) {
                    echo '<button type="button" class="btn-edit btn btn-primary btn-sm">
                    <a href="eventEdit?event_id='.$event->getId().'">Edytuj</a></button>';
                    }
                    ?>
                </div>


                <div class="col participants">
                        <h3>Pracownicy: </h3>
                    <table class="table table-striped table-sm">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Imie</th>
                            <th scope="col">Nazwisko</th>
                            <th scope="col">Rola</th>
                        </tr>
                        <?php
                        foreach ($usersInEvent as $userInEvent): ?>
                        <?php $lp++?>
                        <?php if($userInEvent->getName() === null){
                            echo '
                            <tr>
                            <td></td>
                            <td>BRAK DODANYCH PRACOWNIKÓW</td>
                            <td></td>
                            <td></td></tr>
                            </table>
                            <button type="button" class="btn-edit btn btn-primary btn-sm"><a href="eventEditWorkers?event_id='
                                .$event->getId().'">Edytuj</a></button>
                            ';
                            return null;}

                        ?>
                        <tr>
                            <td><?php echo $lp?></td>
                            <td><?= $userInEvent->getName()?></td>
                            <td><?= $userInEvent->getSurname()?></td>
                            <td><?= $userInEvent->getRoleName()?></td>
                            <?php endforeach;?>
                        </tr>
                    </table>
                    <?php
                    if($_SESSION['user_status']=== 3) {
                       echo ' <button type = "button" class="btn-edit btn btn-primary btn-sm" >
                       <a href = "eventEditWorkers?event_id='.$event->getId().'" > Edytuj</a ></button >';
                    }?>
                </div>
            </section>
        </main>
    </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $('.nav-item [href="/events"]').addClass("active");
        $(".nav-item [href='/pastEvents']").removeClass("hidden-link");
        $(".nav-item [href='/pastEvents']").addClass("show-link");
        $(".nav-item [href='/pastEvents']").attr("style","color: #6c757d;");

    </script>
</body>
</html>
