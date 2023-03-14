<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Magazyn</title>
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>
<?php $search = '<input type="search" id="search-depot-input" class="form-control form-control-dark text-bg-dark w-25 me-auto" placeholder="Szukaj....."
           aria-label="Search">'; ?>
<?php include 'public/views/elements/header.php'; ?>
<?php include 'public/views/elements/modal.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Magazyn</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addDepotItem">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="depot">
                <div id="depot class=" table-responsive
                ">
                <div class="table-responsive">
                    <table class="table table-hover table align-middle">
                        <thead class="table-secondary table align-middle">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Zdjęcie</th>
                            <th scope="col">Nazwa</th>
                            <th scope="col">Opis</th>
                            <th scope="col">Kod produktu
                            </td>
                            <th scope="col">Stan magazynowy</th>
                            <th scope="col">Akcja</th>
                        </tr>
                        </thead>
                        <tbody class="items">
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= $item->getId() ?></td>
                                <td><img width="150px" height="150px" src="public/img/uploads/<?= $item->getImage() ?> "
                                </td>
                                <td><?= $item->getName() ?></td>
                                <td><?= $item->getDescription() ?></td>
                                <td><?= $item->getBarcode() ?></td>
                                <td><?= $item->getQuantity() ?></td>
                                <td>
                                    <a href="editDepotItem?item_id=<?= $item->getId() ?>&barcode=<?= $item->getBarcode() ?>">
                                        <button type="button" class="btn-edit btn btn-primary btn-sm">
                                            Zobacz więcej
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
<script type="text/javascript" src="./public/js/search-depot.js"></script>
<script>
    $('.nav-link[href="/depot"]').addClass("active");
</script>

</body>
</html>


<template id="item-template">
    <tr>
        <td class="item-id"></td>
        <td class="item-image"></td>
        <td class="item-name"></td>
        <td class="item-desc"></td>
        <td class="item-barcode"></td>
        <td class="item-quantity"></td>
        <td class="btn-edit"></td>
    </tr>
</template>
</html>