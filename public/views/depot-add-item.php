<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Dodaj przedmiot do magazynu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="public/css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'public/views/elements/header.php';?>
<?php include 'public/views/elements/modal.php';?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php'?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Dodaj przedmiot do magazynu</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="addDepotItem">
                        <button type="button" class="btn btn-primary me-2">Dodaj</button>
                    </a>
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

        <section class="events-edit">
            <form action="addDepotItem" method="POST" ENCTYPE="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nazwa</label>
                    <input name="name" type="text" class="form-control"">
                </div>
                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea name="description" class="form-control" ></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Zdjęcie produktu</label>
                    <input name="image" type="file" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="barcode">Barcode</label>
                    <input name="barcode" type="number" class="form-control"">
                </div>
                <div class="form-group">
                    <label for="item_quantity">Stan magazynowy</label>
                    <input name="item_quantity" type="number"  class="form-control">
                </div>
                <input name="id_assigned_by" type="hidden" value="<?php $_SESSION['user_id'];?>" >
                <button type="submit" class="btn btn-success" >Dodaj</button>
                <input class="btn btn-primary" type="reset" value="Reset">
            </form>
        </section>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="public/js/style.js"></script>

    <script>
        <?php echo $display;?>
        $('.nav-item [href="/warehouse"]').addClass("active");
    </script>

</body>
</html>
