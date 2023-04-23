<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Przypomnij hasło</title>
    <?php include 'public/views/elements/css.php'; ?>
</head>
<body>

<section class="login-container">
    <?php include 'public/views/elements/modal.php' ?>
    <div class="container d-flex justify-content-center ">
        <div class="row gx-lg-10 align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="my-5 display-3 fw-bold ls-tight">
                    Event App <br/>
                    <span class="text-primary">MANAGER</span>
                </h1>
                <p style="color: hsl(217, 10%, 50.8%)">
                    Stwórz nowe hasło!
                </p>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card">
                    <div class="card-body py-5 px-md-5">
                        <form class="forgot-pass-new" action="resetPasswordRequest" method="POST">
                            <div class="form-outline mb-4">
                                <input name="password" type="password" class="form-control"/>
                                <label class="form-label">Podaj nowe hasło</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input name="confirmed_pass" type="password" class="form-control"/>
                                <label class="form-label">Powtórz nowe hasło</label>
                            </div>
                            <input name="selector" type="hidden" value="<?php echo $selector ?>" class="form-control"/>
                            <input name="validator" type="hidden" class="form-control"
                                   value="<?php echo $validator ?>"/>
                            <div class="d-grid gap-1">
                                <button type="submit" name='reset-pwd-submit' class="btn btn-primary btn-block mb-4">
                                    Wyślij
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'public/views/elements/scripts.php' ?>
<script type="text/javascript" src="./public/js/password-valid.js"></script>
</body>
</html>
