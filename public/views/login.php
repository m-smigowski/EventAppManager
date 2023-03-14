<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Login</title>
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
                    Zaloguj się jeżeli chcesz przejść dalej. Jeżeli nie masz konta, skontaktuj się z administratorem.
                </p>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card">
                    <div class="card-body py-5 px-md-5">
                        <form class="login" action="login" method="POST">
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input name="email" type="text" id="form3Example3" class="form-control"/>
                                <label class="form-label" for="form3Example3">Adres e-mail</label>
                            </div>
                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input name="password" type="password" id="form3Example4" class="form-control"/>
                                <label class="form-label" for="form3Example4">Hasło</label>
                            </div>
                            <!-- Submit button -->
                            <div class="d-grid gap-1">
                                <button type="submit" class="btn btn-primary btn-block mb-4">
                                    Zaloguj się
                                </button>
                            </div>

                            <div class="forgot-pass"><a href="/forgotPass">Przypomnij hasło</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include 'public/views/elements/scripts.php' ?>
<script>
    <?php echo $display;?>
</script>
</body>
</html>
