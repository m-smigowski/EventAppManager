<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Magazyn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="public/css/style.css" rel="stylesheet">

</head>
<style>

    .btn-edit>a{
        text-decoration: none;
        display: block;
        color: white;
    }

</style>
<body>

<?php include 'public/views/elements/header.php';?>

<div class="container-fluid">
  <div class="row">
      <?php include 'public/views/elements/nav.php'?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Magazyn</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group ">
              <button type="button" class="btn btn-sm btn-outline-secondary"><a href="addDepotItem">Dodaj</a></button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick = "location.reload()">Odśwież</button>
          </div>
        </div>
      </div>

        <section class="warehouse">
            <div id="warehouse class="table-responsive">
                <table class="table table-striped table-sm">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Status</th>
                        <th scope="col">Typ</td>
                        <th scope="col">Data wydarzenia</th>
                        <th scope="col">Akcja</th>
                    </tr>
                </table>
            </div>
        </section>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="public/js/style.js"></script>

    <script>
        $('.nav-item [href="/warehouse"]').addClass("active");
    </script>

</body>
</html>
