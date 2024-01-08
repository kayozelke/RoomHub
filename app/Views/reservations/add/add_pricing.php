<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">
            <h3>Nowa rezerwacja - podsumowanie</h3>
            <hr>

            <div class="overflow-x-auto">
                <table class="table m-0">
                    <tbody>
                        <tr>
                            <td scope="row" class="fw-light">Użytkownik:</td>
                            <td class="text-end">
                                <?= $current_user['firstname'] . ' ' . $current_user['lastname'] ?>
                                (<em><?= $current_user['email'] ?></em>)
                            </td>
                            <!-- <td class="text-end"></td> -->
                        </tr>
                        <tr>
                            <td scope="row" class="fw-light">Obiekt:</td>
                            <td class="text-end"><?= $current_building['name'] ?></td>
                        </tr>
                        <tr>
                            <td scope="row" class="fw-light">Rodzaj pokoju:</td>
                            <td class="text-end"><?= $current_room_type['name'] ?><br>(<?= $current_room_type['price_month'] ?> PLN/mies.)</td>
                        </tr>
                        <tr>
                            <td scope="row" class="fw-light">Nr pokoju / miejsce:</td>
                            <td class="text-end"><?= $current_room['number'] ?> / <?= $current_slot['name'] ?></td>
                        </tr>

                        <tr>
                            <td scope="row" class="fw-light">Data rozpoczęcia / zakończenia:</td>
                            <td class="text-end"><?= $general_start_date ?> / <?= $general_end_date ?></td>
                        </tr>
                        <?php /*
                        <tr>
                            <td scope="row" class="fw-light">Data rozpoczęcia:</td>
                            <td class="text-end"><?= $general_start_date ?></td>
                        </tr>
                        <tr>
                            <td scope="row" class="fw-light">Data zakończenia:</td>
                            <td class="text-end"><?= $general_end_date ?></td>
                        </tr>  */ ?>
                        <?php if ($current_query['method'] == 'monthly') : ?>

                            <tr>
                                <td scope="row" class="fw-light">Domyślna opłata miesięczna:</td>
                                <td class="text-end"><?= $current_room_type['price_month'] ?> PLN</td>
                            </tr>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <form class="" method="post" action="/reservations/add_final">
                <input type="hidden" name="method" value="<?= $current_query['method'] ?>">
                <input type="hidden" name="building_id" value="<?= $current_building['id'] ?>">
                <input type="hidden" name="room_number" value="<?= $current_room['number'] ?>">
                <input type="hidden" name="slot_id" value="<?= $current_slot['id'] ?>">
                <input type="hidden" name="user_email" value="<?= $current_user['email'] ?>">
                <input type="hidden" name="general_start_date" value="<?= $general_start_date  ?>">
                <input type="hidden" name="general_end_date" value="<?= $general_end_date  ?>">


                <div class="row py-1 mt-2">

                    <div class="col-auto">
                        <label for="price" class="form-label">Opłata <?= ($current_query['method'] == 'daily') ? "za wynajem krótkookresowy" : "miesięczna" ?> (PLN)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required value="<?=($current_query['method'] == 'daily') ? null : $current_room_type['price_month'] ?>" placeholder="0">
                    </div>

                </div>

                <div class="row py-1 mt-2">

                    <div class="col-12">
                        <label for="notes" class="form-label">Dodatkowe uwagi (opcjonalnie)</label>
                        <input class="form-control" type="text" name="notes" id="notes" placeholder="" maxlength="255">
                        <!-- <textarea class="form-control" aria-label="With textarea" name="notes" id="notes" placeholder="" maxlength="255"></textarea> -->
                    </div>

                </div>


                <div class="row">


                    <div class="container pt-3">
                        <?php if (session()->get('form_validation_failure')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->get('form_validation_failure') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
                <!-- Buttons -->
                <div class="row align-items-center">
                    <div class="col d-flex justify-content-start">
                        <a href="/reservations" class="btn btn-danger bg-gradient">Anuluj</a>
                        <a href="/reservations/add_details?<?= http_build_query($current_query) ?>" class="mx-1 btn btn-secondary bg-gradient">Wstecz</a>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary bg-gradient">Zatwierdź</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>