<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">
            <h3>Nowa rezerwacja</h3>
            <hr>
            <form class="" method="get" action="/reservations/add_details/">

                <div class="row">

                    <div class="col-12 col-sm-12 pt-1 pb-1">
                        <label for="user_email" class="form-label">Użytkownik</label>
                        <input class="form-control" list="userList" name="user_email" placeholder="Wyszukaj..." id="user_email" required value="<?=(isset($current_user_email) && $current_user_email) ? $current_user_email : null?>">
                        <datalist id="userList">
                            <?php foreach ($users as $row) : ?>
                                <option value="<?= $row['email'] ?>"><?= $row['firstname'] . ' ' . $row['lastname'] ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 pt-1 pb-1">
                        <label for="building_id" class="form-label">Obiekt</label>
                        <select class="form-select" name="building_id" id="building_id">
                            <option value="">Wybierz obiekt</option>
                            <?php foreach ($buildings as $row) : ?>
                                <option value="<?= $row['id'] ?>" <?= (isset($current_building_id) && $row['id'] == $current_building_id) ? 'selected=""' : null ?>><?= $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <label for="room_number" class="form-label">Pokój</label>
                        <input type="text" class="form-control" name="room_number" placeholder="Wyszukaj... (po wybraniu obiektu)" list="roomList" id="room_number" value="<?= (isset($current_room_number) && "" != $current_room_number) ? $current_room_number : null ?>">
                        <datalist id="roomList"></datalist>
                    </div>

                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <label for="slot_id" class="form-label">Miejsce</label>
                        <select class="form-select" name="slot_id" id="slot_id">
                            <option value="-1">Brak danych</option>
                        </select>
                    </div>

                    <div class="container pt-3">
                        <?php /*if (isset($error_msg)) : ?>
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $error_msg ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php endif;*/ ?>
                        

                        <?php if (session()->get('form_validation_failure')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->get('form_validation_failure') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                    </div>

                </div>

                <div class="row align-items-center">
                    <div class="col d-flex justify-content-start">
                        <a href="/reservations" class="btn btn-danger bg-gradient">Anuluj</a>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button type="submit" class="btn btn-secondary bg-gradient">Dalej</button>
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
        var slotSelect = document.getElementById('slot_id');

        buildingSelect.addEventListener('change', function() {
            var selectedBuildingId = this.value;
            roomSelect.value = '';
            // slotSelect.innerHTML = '<option value="">Brak danych</option>';

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



<script>
    // dynamic loading of room slots
    document.addEventListener('DOMContentLoaded', function() {
        var buildingSelect = document.getElementById('building_id');
        var roomSelect = document.getElementById('room_number');
        var slotSelect = document.getElementById('slot_id');

        updateSlots(buildingSelect, roomSelect, slotSelect);
        // setTimeout(function() {
        // }, 0);

        ['change', 'input'].forEach(function(evt) {

            roomSelect.addEventListener(evt, function() {
                updateSlots(buildingSelect, roomSelect, slotSelect);
            });

        });

        function updateSlots(building_select_element, room_select_element, slot_select_element) {
            // console.log("TEST");
            var selectedBuildingId = buildingSelect.value;
            var selectedRoomNumber = roomSelect.value;

            if (selectedRoomNumber == "" || selectedBuildingId=="") {
                slotSelect.innerHTML = '';
                var option = document.createElement('option');
                option.value = "-1";
                option.textContent = "Brak danych dla wybranego pokoju";
                slotSelect.appendChild(option);
                return
            }

            // AJAX fetching when building_id changed
            fetch('/get_slots_by_room_number_by_building_id/' + selectedBuildingId + '/' + selectedRoomNumber)
                .then(response => response.json())
                .then(data => {
                    // clear current options
                    slotSelect.innerHTML = '';

                    // add new options to roomSelect
                    data.forEach(slot => {
                        var option = document.createElement('option');
                        option.value = slot.slot_id;
                        option.textContent = slot.name;
                        if (slot.slot_id == (new URLSearchParams(window.location.search)).get('slot_id'))
                            option.setAttribute('selected', true);
                        slotSelect.appendChild(option);
                    });
                    if (data.length == 0) {
                        // console.log("nothing!");
                        var option = document.createElement('option');
                        option.value = "-1";
                        option.textContent = "Brak danych dla wybranego pokoju";
                        slotSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    // console.error('Error while getting slots:', error);
                    var option = document.createElement('option');
                    option.value = " ";
                    option.textContent = "Wybrany pokój jest nieprawidłowy";
                    slotSelect.appendChild(option);
                });





        };

    });
</script>