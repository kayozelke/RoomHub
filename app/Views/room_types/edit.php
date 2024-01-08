<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">
            <h3>Edycja typu pokoju</h3>
            <hr>
            <!-- <h6>np. <em>Dom Studencki nr 1</em></h6><br> -->
            <form class="" method="post">
                <div class="row">
                    <div class="col-12 pt-1 pb-1">
                        <div class="form-group">
                            <label for="name" class="form-label">Nazwa typu pokoju</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="np. Pokój 2-osobowy Premium" required maxlength="255" value="<?= $data['name'] ?>">
                        </div>
                    </div>


                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <label for="price_month" class="form-label">Mięsieczny czynsz (PLN)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="price_month" name="price_month" required value="<?= $data['price_month'] ?>">
                    </div>

                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <label for="max_residents" class="form-label">Liczba miejsc</label>
                        <input type="number" class="form-control" id="max_residents" name="max_residents" min="1" max="20" required value="<?= $data['max_residents'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="container pt-3">
                        <div class="col-auto">
                            <div class="alert alert-warning" role="alert">
                                Uwaga! Zmiana wysokości czynszu nie wpływa na istniejące rezerwacje.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
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
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary bg-gradient">Zapisz</button>
                        <a href="/roomtypes" class="btn btn-danger bg-gradient">Anuluj</a>
                    </div>
                    <!-- <div class="col-12 col-sm-8 text-right">
                            <a href="/">Already have an account</a>
                        </div> -->
                </div>
            </form>
        </div>
    </div>
</div>