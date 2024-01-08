<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">
            <h3>Rejestracja</h3>
            <hr>
            <form class="" action="/register" method="post">
                <!-- <form class="" action="<?= base_url('/users/register') ?>" method="post"> -->
                <div class="row">
                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <div class="form-group">
                            <label for="firstname">Imię</label>
                            <!-- TODO - add required -->
                            <input type="text" class="form-control" name="firstname" id="firstname" value="<?= set_value('firstname') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <div class="form-group">
                            <label for="lastname">Nazwisko</label>
                            <!-- TODO - add required -->
                            <input type="text" class="form-control" name="lastname" id="lastname" value="<?= set_value('lastname') ?>">
                        </div>
                    </div>
                    <div class="col-12 pt-1 pb-1">
                        <div class="form-group">
                            <label for="email">Adres email</label>
                            <!-- TODO - add required -->
                            <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <div class="form-group">
                            <label for="password">Hasło</label>
                            <!-- TODO - add required -->
                            <input type="password" class="form-control" name="password" id="password" value="">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <div class="form-group">
                            <label for="password_confirm">Potwierdź hasło</label>
                            <!-- TODO - add required -->
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="">
                        </div>
                    </div>
                    <div class="container pt-3">

                        <?php if (isset($validation)) : ?>
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <?= $validation->listErrors() ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-4">
                        <button type="submit" class="btn btn-primary bg-gradient">Zarejestruj</button>
                    </div>
                    <!-- <div class="col-12 col-sm-8 text-right">
                            <a href="/">Already have an account</a>
                        </div> -->
                </div>
            </form>
        </div>
    </div>
</div>