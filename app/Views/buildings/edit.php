    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
            <div class="container">
                <h3><i class="bi-building"></i> Edycja istniejącego obiektu</h3>
                <hr>
                <form class="" method="post" <?php
                                                // Do not need to use 'action', because we are redirecting to ourself
                                                //action="/buildings/edit/ ... " 
                                                ?>>
                    <div class="row">
                        <div class="col-12 pt-1 pb-1">
                            <div class="form-group">
                                <label for="name">Pełna nazwa obiektu</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?= $data['name'] ?>" placeholder="np. Dom Studencki nr 1">
                            </div>
                        </div>

                        <div class="col-12 pt-1 pb-1">
                            <div class="form-group pt-1 pb-1">
                                <label for="description">Adres</label>
                                <!-- <span class="input-group-text">Opis</span> -->
                                <input type="text" class="form-control" name="address" id="address" value="<?= $data['address'] ?>" placeholder="np. ul. Strzelecka 58/15A, 61-150 Poznań">
                            </div>
                        </div>

                        <div class="col-12 pt-1 pb-1">
                            <div class="form-group pt-1 pb-1">
                                <label for="description">Opis widoczny na stronie obiektu</label>
                                <!-- <span class="input-group-text">Opis</span> -->
                                <?php
                                $formatted_description = $data['description'];
                                $formatted_description = str_replace("<br>", "&#013;", $data['description']);
                                $formatted_description = str_replace("<br/>", "&#013;", $formatted_description);
                                $formatted_description = str_replace("<br />", "&#013;", $formatted_description);
                                ?>
                                <textarea class="form-control" aria-label="With textarea" name="description" id="description" placeholder=""><?= $formatted_description ?></textarea>
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
                            <button type="submit" class="btn btn-primary bg-gradient">Zapisz</button>
                            <a href="/buildings/info/<?= $data['id'] ?>" class="btn btn-danger bg-gradient">Anuluj</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>