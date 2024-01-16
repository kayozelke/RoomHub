<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">
            <!-- <h3>Profile settings</h3> -->
            <?php /* <h3><?= $user['firstname'] . ' ' . $user['lastname'] ?></h3> */ ?>
            <h3>Edycja danych konta</h3>
            <hr>

            <form class="" action="/profile" method="post">
                <!-- <form class="" action="<?= base_url('/users/profile') ?>" method="post"> -->
                <div class="row">
                    <div class="col-12 col-lg-6 pt-1 pb-1">
                        <div class="form-group">
                            <label for="firstname">Imię</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" value="<?= set_value('firstname', $user['firstname']) //second param is default value
                                                                                                            ?>" required <?=(!(session()->isModerator)) ? 'disabled' : null ?>>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 pt-1 pb-1">
                        <div class="form-group">
                            <label for="lastname">Nazwisko</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" value="<?= set_value('lastname', $user['lastname']) ?>" required <?=(!(session()->isModerator)) ? 'disabled' : null ?>>
                        </div>
                    </div>
                    <div class="col-12 pt-1 pb-1">
                        <div class="form-group">
                            <label for="email">Adres e-mail</label>
                            <input type="text" class="form-control" disabled id="email" value="<?= $user['email'] ?>">
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 pt-1 pb-1">
                        <div class="form-group">
                            <label for="password">Nowe hasło (opcjonalnie)</label>
                            <input type="password" class="form-control" name="password" id="password" value="">
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 pt-1 pb-1">
                        <div class="form-group">
                            <label for="password_confirm">Potwierdź nowe hasło (opcjonalnie)</label>
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
                        <button type="submit" class="btn btn-primary bg-gradient">Aktualizuj</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>