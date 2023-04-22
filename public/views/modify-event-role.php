<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Edycja stanowisk pracy</title>
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>

<?php include 'public/views/elements/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'public/views/elements/nav.php' ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edycja stanowisk pracy</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="location.reload()">Odśwież</button>
                </div>
            </div>

            <section class="events-edit">
                <form class="w-75 box" action="dropEventRole" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label class="mb-2"><strong>Lista obecnych stanowisk</strong></label>
                        <select name="role_name" multiple class="form-control" id="RoleList">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['role_name']; ?>"><?= $role['role_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger mt-2 mb-4">Usuń</button>
                </form>


                <form class="w-75 box mt-2" action="addEventRole" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label class="mb-2" for="title"><strong>Nazwa stanowiska</strong></label>
                        <input name="role_name" type="text" class="form-control"">
                    </div>
                    <button type="submit" class="btn btn-success mt-2 mb-4">Dodaj</button>
                    <button type="button" class="btn btn-primary mt-2 mb-4"
                            onclick="window.location.href='/adminPanel'">Wróć
                    </button>

                </form>

            </section>
        </main>
    </div>
</div>
<?php include 'public/views/elements/scripts.php' ?>
<script>
    $(".submenu-events").removeClass("show")
    $(".submenu-adminpanel").addClass("show");
    $('.nav-item [href="/modifyEventRole"]').addClass("active");
</script>

</body>
</html>
