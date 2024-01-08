<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper">
        <div class="container">

            <h3>Filtrowanie rezerwacji</h3>
            <hr>
            <form method="get" action="/reservations" class="form-inline">
                <div class="row">

                    <div class="col-12 py-1">
                        <label for="user_email" class="form-label">Adres email użytkownika</label>
                        <input type="text" class="form-control" name="user_email" id="user_email" value="<?= (isset($query['user_email'])) ? $query['user_email'] : null ?>" placeholder="(dowolny)" maxlength="255">
                    </div>

                    <div class="col-12 py-1">
                        <label for="building_id" class="form-label">Obiekt</label>
                        <select name="building_id" id="building_id" class="form-select me-2">
                            <option selected value="" <?= (!isset($query['building_id'])) ? "selected" : null ?>>
                                (dowolny)
                            </option>
                            <?php foreach ($buildings as $building) : ?>
                                <option value="<?= $building['id'] ?>" <?= (isset($query['building_id']) && $query['building_id'] == $building['id']) ? "selected" : null ?>>
                                    <?= $building['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 py-1">
                        <label for="number" class="form-label">Numer pokoju</label>
                        <input type="text" class="form-control" name="number" id="number" value="<?= (isset($query['number'])) ? $query['number'] : null ?>" placeholder="(dowolny)" maxlength="10">
                    </div>


                    <?php /*
                    <div class="col-12 col-sm-6 py-1">
                        <label for="room_type_id" class="form-label">Typ pokoju</label>
                        <select class="form-select" name="room_type_id" id="room_type_id">
                            <option selected value="">(dowolny)</option>
                            <?php foreach ($room_types as $row) : ?>
                                <option value="<?= $row['id'] ?>">
                                    <?= $row['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    */ ?>
                    <div class="col-12 col-sm-6 py-1">
                        <label class="form-label">Okres rezerwacji</label>
                        <div class="d-flex">
                            <?php /*
                            <input name="start_date" id="start_date" class="form-control me-2" type="date" value="<?= (isset($query['start_date'])) ? $query['start_date'] : null ?>" />
                            <input name="end_date" id="end_date" class="form-control" type="date" value="<?= (isset($query['end_date'])) ? $query['end_date'] : null ?>" />
                            */ ?>
                            <input name="year_month" id="monthyear" class="form-control" type="month" value="<?= (isset($query['year_month'])) ? $query['year_month'] : null ?>" />
                        </div>
                    </div>


                    <div class="container pt-3">

                        <?php if (isset($error_msg)) : ?>
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <?= $error_msg ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 py-1">
                        <button type="submit" class="btn btn-primary bg-gradient">Filtruj</button>
                    </div>
                </div>

            </form>




        </div>
    </div>
</div>