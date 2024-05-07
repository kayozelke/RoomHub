<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-primary-subtle border from-wrapper shadow">
    <!-- <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 border from-wrapper bg-img-room"> -->
        <div clas="container">
            <h3>Logowanie</h3>
            <hr>

            <form class="" action="/" method="post">
                <div class="form-group">
                    <label for="email">Adres email</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>" required> 
                </div>
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" class="form-control" name="password" id="password" value="<?= set_value('password') ?>" required>
                </div>

                <div class="pt-3">

                    <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-4">
                        <button type="submit" class="btn btn-primary bg-gradient">Zaloguj</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>