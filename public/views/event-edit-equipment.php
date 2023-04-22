<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Edycja sprzętu zarezerwowanego dla wydarzenia</title>
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
                <h1 class="h4">Edycja sprzętu zarezerwowanego dla wydarzenia</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="eventEditEquipment">
                <h1 class="h5">Dodaj przedmiot do wydarzenia</h1>
                <form action="addEquipmentToRent?event_id=<?php echo $_GET['event_id']; ?>" method="POST"
                      ENCTYPE="multipart/form-data">
                    <div class="row">
                        <div class="col-6">
                            <label for="id_name_barcode_item">Wybierz sprzęt</label>
                            <select name="id_name_barcode_item" multiple class="form-control">
                                <?php foreach ($items as $item): ?>
                                    <option value="<?= $item->getId(); ?> <?= $item->getName(); ?> <?= $item->getBarcode(); ?>">
                                        ID: <?= $item->getId(); ?> Nazwa: <?= $item->getName(); ?>
                                        Barcode: <?= $item->getBarcode(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="id_name_barcode_item">Ilość:</label>
                            <input name="quantity_to_rent" type="number" class="form-control">
                        </div>

                        <div class="col">
                            <label for="id_name_barcode_item">Uwagi:</label>
                            <textarea name="comments" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                    <input name="event_id" type="hidden" value="<?php echo $_GET['event_id']; ?>">
                    <button type="submit" class="btn btn-success mt-2" value="Zaktualizuj">Dodaj</button>
                    <button type="button" class="btn btn-primary mt-2"
                            onclick="window.location.href='/eventViewDetails?event_id=<?php echo $_GET['event_id']; ?>'">
                        Wróć
                    </button>
                </form>

                <div class="rented_items">
                    <h1 class="h5">Lista przedmiotów wynajętych dla wydarzenia:</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <tr>
                                <th scope="col">ID produktu</th>
                                <th scope="col">Zdjęcie</th>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Kod produktu</th>
                                <th scope="col">Ilość</th>
                                <th scope="col">Uwagi</th>
                                <th scope="col">Akcja</th>
                            </tr>
                            <?php
                            foreach ($rented_items
                            as $rented_item): ?>
                            <tr>
                                <td><?= $rented_item['id'] ?></td>
                                <td><img width="100px" height="100px"
                                         src="public/img/uploads/<?= $rented_item['image'] ?> "</td>
                                <td><?= $rented_item['name'] ?></td>
                                <td><?= $rented_item['barcode'] ?></td>
                                <td><?= $rented_item['quantity'] ?></td>
                                <td><?= $rented_item['comments'] ?></td>
                                <td>
                                    <a href="eventEditEquipment?event_id=<?= $_GET['event_id'] ?>&rental_id=<?= $rented_item['rental_id'] ?>">
                                    <button type="button" class="btn-edit btn btn-primary btn-sm">Usuń</button>
                                    </a>
                                </td>
                                <?php endforeach; ?>
                            </tr>

                        </table>
                    </div>

                </div>
            </section>
        </main>
    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>
</body>
</html>
