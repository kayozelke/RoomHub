<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper">
        <div class="container">
            <h3>Rezerwacja nr #<?= $current_reservation['reservation_id'] ?></h3>
            <hr>
            <form class="" method="post" <?php
                                            // Do not need to use 'action', because we are redirecting to ourself
                                            ?>>
                <div class="row">
                    <div class="col-12 pt-1 pb-1">
                        <p class="py-1 my-1">Status wpłaty</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_done" id="paymentNotRealisedSelect" checked value="payment_not_realised" <?= (isset($current_reservation['reservation_payment_done']) && $current_reservation['reservation_payment_done'] == 0) ? 'checked' : null ?>>
                            <label class="form-label" for="paymentNotRealisedSelect"> <em>nieopłacone</em> </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_done" id="paymentRealisedSelect" value="payment_realised" <?= (isset($current_reservation['reservation_payment_done']) && $current_reservation['reservation_payment_done'] == 1) ? 'checked' : null ?>>
                            <label class="form-check-label" for="paymentRealisedSelect"> <em>opłacone</em> </label>
                        </div>
                    </div>

                    <div class="col-12 pt-1 pb-1">
                        <div class="form-group pt-1 pb-1">
                            <label for="notes" class="form-label">Dodatkowe uwagi (opcjonalnie)</label>
                            <input class="form-control" type="text" name="notes" id="notes" placeholder="" maxlength="255" value="<?= $current_reservation['reservation_notes'] ?>">
                        </div>
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

                <div class="row">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary bg-gradient">Zapisz</button>
                        <a href="/reservations/info/<?= $current_reservation['reservation_id'] ?>" class="btn btn-danger bg-gradient">Anuluj</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>