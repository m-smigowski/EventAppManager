<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Przypomnij hasło</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="public/css/style.css" rel="stylesheet">
</head>
<body>

<section class="login-container">
    <?php include 'public/views/elements/modal.php' ?>
        <div class="container d-flex justify-content-center ">
            <div class="row gx-lg-10 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="my-5 display-3 fw-bold ls-tight">
                        Event App <br />
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
                                <!-- Email input -->
                                <div class="form-outline mb-4">
                                    <input name="password" type="password" class="form-control" />
                                    <label class="form-label">Podaj nowe hasło</label>
                                </div>
                                <!-- Email input -->
                                <div class="form-outline mb-4">
                                    <input name="confirmed_pass" type="password" class="form-control" />
                                    <label class="form-label">Powtórz nowe hasło</label>
                                </div>
                                <input name="selector" type="hidden"  value="<?php echo $selector?>" class="form-control" />
                                <input name="validator" type="hidden" class="form-control" value="<?php echo $validator?>"/>
                                <!-- Submit button -->
                                <div class="d-grid gap-1">
                                    <button type="submit"  name='reset-pwd-submit' class="btn btn-primary btn-block mb-4">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="./public/js/password-valid.js"></script>
<script src=""></script>
<script>
    <?php echo $display;?>
</script>
</body>
</html>
