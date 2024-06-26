<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Edycja przedmiotu w magazynie</title>
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>

<?php include 'public/views/elements/header.php';?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php'?>
        <?php include 'public/views/elements/modal.php'?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Edycja przedmiotu w magazynie</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addDepotItem">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="item-edit">
                <form action="editDepotItem" class="box w-75" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input name="name" type="text" class="form-control" value="<?= $item->getName()?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Opis</label>
                        <textarea name="description" class="form-control"  rows="3"><?= $item->getDescription()?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Obecne zdjęcie</label><br>
                        <img src="public/img/uploads/<?= $item->getImage()?>"><br>
                        <label>Wgraj nowe zdjęcie</label>
                        <input name="old_image" type="hidden" value="<?= $item->getImage()?>">
                        <input name="image" type="file" class="form-control" ">
                    </div>
                    <div class="form-group">
                        <label for="barcode">Kod produktu</label>
                        <input name="barcode" type="number" class="form-control"  value="<?= $item->getBarcode()?>">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Stan magazynowy</label>
                        <input name="quantity" type="number" class="form-control"  value="<?= $item->getQuantity()?>">
                    </div>

                    <input name="item_id" type="hidden" value="<?= $item->getID()?>">

                    <button type="submit" class="btn btn-success mt-2 mb-2" name="Update">Zaktualizuj</button>
                    <button class="btn btn-primary mt-2 mb-2" name="Update">Wróć</button>
                    <button type="submit" class="btn btn-danger mt-2 mb-2 me-auto" name="Drop"> Usuń</button>
                </form>

            </section>
    </div>
</div>

<?php include 'public/views/elements/scripts.php' ?>
</body>
</html>
