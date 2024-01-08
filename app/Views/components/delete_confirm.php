<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">
            <h3><?= $title ?></h3>
            <hr>
            <form class="" method="post" action="<?= $dest_submit ?>">
                <div class="row pt-4 align-items-center justify-content-center">

                    <div class="col-auto">
                        <h6><?=$question?></h6>
                    </div>
                    <!-- <div class="col-auto">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
                            <label class="form-check-label" for="inlineRadio3">3 (disabled)</label>
                        </div>
                    </div> -->
                </div>

                <div class="row py-4 align-items-center justify-content-center">
                    <div class="col-auto">
                        <input type="hidden" name="confirm" value="true">
                        <button type="submit" class="btn btn-primary bg-gradient mx-4"><i class="bi bi-check-lg"></i> Wykonaj</button>
                        <a href="<?= $dest_cancel ?>" class="btn btn-danger bg-gradient mx-4"><i class="bi bi-x-lg"></i> Anuluj</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>