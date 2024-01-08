<!-- DataList -->
<datalist id="userList">
    <?php foreach ($users as $row) : ?>
        <option value="<?= $row['email'] ?>"><?= $row['firstname'] . ' ' . $row['lastname'] ?></option>
    <?php endforeach; ?>
</datalist>

<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">

            <h3>Wyszukiwanie rezerwacji</h3>
            <hr>
            <form method="get" action="/reservations/by_filter" class="form-inline">
                <div class="row">
                    <div class="col-12 col-xl-4 col-md-6 py-1">
                        <label for="user_email" class="form-label">Numer rezerwacji</label>
                        <div class="input-group">
                            <span class="input-group-text">#</span>
                            <input name="reservation_id" id="reservation_id" type="number" class="form-control" placeholder="(dowolny)" min="1" value="<?= (isset($current_query['reservation_id'])) ? $current_query['reservation_id'] : null ?>">
                        </div>
                    </div>

                    <div class="col-12 col-xl-4 col-md-6 py-1">
                        <label for="status" class="form-label">Status rezerwacji</label>
                        <select name="status" id="status" class="form-select me-2">
                            <option selected value="" <?= (!isset($current_query['status'])) ? "selected" : null ?>> (dowolny) </option>
                            <option value="0" <?= (isset($current_query['status']) && $current_query['status'] == 0) ? "selected" : null ?>> zakończone </option>
                            <option value="1" <?= (isset($current_query['status']) && $current_query['status'] == 1) ? "selected" : null ?>> aktywne </option>
                            <option value="2" <?= (isset($current_query['status']) && $current_query['status'] == 2) ? "selected" : null ?>> nierozpoczęte </option>
                        </select>
                    </div>

                    <div class="col-12 col-xl-4 d-flex py-2 align-items-end justify-content-center">
                        <div class="p-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="show_deleted" id="show_deleted" value="1" <?= (isset($current_query['show_deleted'])) ? 'checked' : null ?>>
                                <label class="form-check-label" for="show_deleted">Pokaż archiwalne</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12 py-1">
                        <label for="user_email" class="form-label">Adres email użytkownika</label>
                        <input type="text" class="form-control" list="userList" name="user_email" id="user_email" value="<?= (isset($current_query['user_email'])) ? $current_query['user_email'] : null ?>" placeholder="(dowolny)" maxlength="255">
                    </div>

                    <div class="col-12 col-lg-7 py-1">
                        <label for="building_id" class="form-label">Obiekt</label>
                        <select name="building_id" id="building_id" class="form-select me-2">
                            <option selected value="" <?= (!isset($current_query['building_id'])) ? "selected" : null ?>>
                                (dowolny)
                            </option>
                            <?php foreach ($buildings as $building) : ?>
                                <option value="<?= $building['id'] ?>" <?= (isset($current_query['building_id']) && $current_query['building_id'] == $building['id']) ? "selected" : null ?>>
                                    <?= $building['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-lg-5 py-1">
                        <label for="room_number" class="form-label">Numer pokoju</label>

                        <input type="text" class="form-control" name="room_number" placeholder="(dowolny)" list="roomList" id="room_number" value="<?= (isset($current_query['room_number']) && "" != $current_query['room_number']) ? $current_query['room_number'] : null ?>">
                        <datalist id="roomList"></datalist>
                    </div>


                    <div class="col-12 col-md-6 py-1">
                        <label class="form-label">Od dnia (opcjonalnie)</label>
                        <input name="start_date" id="start_date" class="form-control me-2" type="date" value="<?= (isset($current_query['start_date'])) ? $current_query['start_date'] : null ?>" />
                    </div>

                    <div class="col-12 col-md-6 py-1">
                        <label class="form-label">Do dnia (opcjonalnie)</label>
                        <input name="end_date" id="end_date" class="form-control me-2" type="date" value="<?= (isset($current_query['end_date'])) ? $current_query['end_date'] : null ?>" />
                        <?php /*
                            <input name="year_month" id="monthyear" class="form-control" type="month" value="<?= (isset($current_query['year_month'])) ? $current_query['year_month'] : null ?>" />
                            */ ?>
                    </div>

                    <div class="col-12 col-md-5 py-1">
                        <label for="payment_done" class="form-label">Stan płatności</label>
                        <select name="payment_done" id="payment_done" class="form-select me-2">
                            <option selected value="" <?= (!isset($current_query['payment_done'])) ? "selected" : null ?>> (dowolny) </option>
                            <option value="0" <?= (isset($current_query['payment_done']) && $current_query['payment_done'] == "0") ? "selected" : null ?>> nieopłacone </option>
                            <option value="1" <?= (isset($current_query['payment_done']) && $current_query['payment_done'] == "1") ? "selected" : null ?>> opłacone </option>
                        </select>
                    </div>

                    <div class="container pt-3">
                        <?php if (session()->get('form_validation_failure')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->get('form_validation_failure') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 py-1">
                        <button type="submit" class="btn btn-primary bg-gradient">Wyszukaj</button>
                        <a href="/reservations/filter_settings" type="submit" class="btn btn-secondary bg-gradient">Wyczyść</a>
                        <a href="/reservations/" type="submit" class="btn btn-danger bg-gradient">Anuluj</a>
                    </div>
                </div>

            </form>




        </div>
    </div>
</div>



<script>
    // dynamic loading of rooms' numbers
    document.addEventListener('DOMContentLoaded', function() {
        var buildingSelect = document.getElementById('building_id');
        var roomDataList = document.getElementById('roomList');
        var roomSelect = document.getElementById('room_number');

        buildingSelect.addEventListener('change', function() {
            var selectedBuildingId = this.value;
            roomSelect.value = '';

            // AJAX fetching when building_id changed
            fetch('/get_rooms_of_building/' + selectedBuildingId)
                .then(response => response.json())
                .then(data => {
                    // clear current options
                    roomDataList.innerHTML = '';

                    // add new options to roomDataList
                    data.forEach(room => {
                        var option = document.createElement('option');
                        option.value = room.room_number;
                        option.textContent = room.room_type_name;
                        roomDataList.appendChild(option);
                    });
                    if (data.length == 0) {
                        // console.log("nothing!");
                        var option = document.createElement('option');
                        option.value = "";
                        option.textContent = "Brak danych dla wybranego obiektu";
                        roomDataList.appendChild(option);
                    }
                })
                .catch(error => {
                    // console.error('Error while getting rooms:', error);
                    var option = document.createElement('option');
                    option.value = " ";
                    option.textContent = "Błąd podczas pobierania danych";
                    roomDataList.appendChild(option);
                });
        });
    });
</script>