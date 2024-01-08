<div class="row">
    <div class="col-12 col-sm-12 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper">
        <div class="container">
            <h3>Nowa rezerwacja</h3>
            <hr>
            <form class="" method="get">
                <div class="row">

                    <div class="col-12 col-sm-3 pt-1 pb-1">
                        <label for="user_email" class="form-label">Użytkownik</label>
                        <input class="form-control" list="userList" name="user_email" placeholder="Wyszukaj..." id="user_email">
                        <datalist id="userList">
                            <?php foreach ($users as $row) : ?>
                                <option value="<?= $row['email'] ?>"><?= $row['firstname'] . ' ' . $row['lastname'] ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>

                    <div class="col-12 col-sm-3 pt-1 pb-1">
                        <label for="start_date" class="form-label">Data początkowa</label>
                        <input class="form-control" type="date" name="start_date" placeholder="" id="start_date">
                    </div>

                    <div class="col-12 col-sm-3 pt-1 pb-1">
                        <label for="end_date" class="form-label">Data końcowa</label>
                        <input class="form-control" type="date" name="end_date" placeholder="" id="end_date">
                    </div>


                    <?php /*

                        <div class="col-12 pt-1 pb-1">
                            <label for="building_id" class="form-label">Obiekt</label>
                            <select class="form-select" name="building_id" id="building_id">
                                <option value="">Wybierz obiekt</option>
                                <?php foreach ($buildings as $row) : ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 pt-1 pb-1">
                            <label for="room_number" class="form-label">Numer pokoju</label>
                            <input type="text" class="form-control" name="room_number" placeholder="Wyszukaj... (po wybraniu obiektu)" list="roomList" id="room_number">
                            <datalist id="roomList"></datalist>
                        </div>

                        <div class="col-12 col-sm-6 pt-1 pb-1">
                            <label for="slot_id" class="form-label">Miejsce w pokoju</label>
                            <select class="form-select" name="slot_id" id="slot_id">
                                <option value="">Brak danych</option>
                            </select>
                        </div>

                    */ ?>

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
                <!-- Buttons -->
                <div class="row align-items-center">
                    <div class="col d-flex justify-content-start">
                        <a href="/reservations" class="btn btn-danger bg-gradient">Anuluj</a>
                        <a href="/reservations/add?<?=http_build_query($current_query)?>" class="mx-1 btn btn-secondary bg-gradient">Wstecz</a>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary bg-gradient">Dodaj</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- current reservations view -->
    <div class="col-12 col-sm-12 mt-5 pt-3 pb-3 bg-primary-subtle bg-opacity-50 border from-wrapper">
        <div class="container">
            <h5>Rezerwacje miejsca '<?=$current_slot_name?>' w pokoju <?=$current_room_number?></h5>
            <hr class="mb-1">

            <div class="d-flex align-items-center justify-content-between m-0 border-0 py-1 mb-1 me-1">
                <div class="col-12 col-sm-6">
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <?php
                    # Building query arrays in this VIEW file
                    $query_previous_month = [
                        'building_id' => (isset($current_building_id) && $current_building_id) ? $current_building_id : null,
                        'room_number' => (isset($current_room_number) && $current_room_number) ? $current_room_number : null,
                        'slot_id' => (isset($current_slot_id) && $current_slot_id) ? $current_slot_id : null,
                        'year_month' => (new DateTime($filter_year_month))->modify('-1 month')->format('Y-m'),
                    ];
                    $query_next_month = [
                        'building_id' => (isset($current_building_id) && $current_building_id) ? $current_building_id : null,
                        'room_number' => (isset($current_room_number) && $current_room_number) ? $current_room_number : null,
                        'slot_id' => (isset($current_slot_id) && $current_slot_id) ? $current_slot_id : null,
                        'year_month' => (new DateTime($filter_year_month))->modify('+1 month')->format('Y-m'),
                    ];

                    ?>
                    <a type="button" class="btn btn-sm btn-primary bg-gradient m-0" href="?<?= http_build_query($query_previous_month) ?>"><i class="bi-chevron-double-left"></i></a>
                    <!-- <span class="m-0 mx-2 fw-bold"><?= $filter_year_month ?></span> -->
                    <?php //print_r(http_build_query($current_query)); ?>
                    <form id="month_form" method="get" action="?<?=http_build_query($current_query)?>">
                    
                        <input type="hidden" name="building_id" value="<?=$current_building_id?>">
                        <input type="hidden" name="room_number" value="<?=$current_room_number?>">
                        <input type="hidden" name="slot_id" value="<?=$current_slot_id?>">
                        <input class="m-0 mx-2 fw-bold" type="month" name="year_month" id="month_picker" value="<?= $filter_year_month ?>"></span>
                        <input type="submit" value="Submit" id="submit_button" style="display:none">
                    </form>
                    <a type="button" class="btn btn-sm btn-primary bg-gradient m-0" href="?<?= http_build_query($query_next_month) ?>"><i class="bi-chevron-double-right"></i></a>

                </div>


            </div>

            <!-- <hr class="py-1 m-1"> -->

            <table class="table table-striped table-sm table-bordered text-center py-0" <?=($data) ? 'id="dataTable"' : null ?> >
                <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col" class="text-center">Użytkownik</th>
                        <!-- <th scope="col" class="text-center">Miejsce</th> -->
                        <th scope="col" class="text-center">Początek</th>
                        <th scope="col" class="text-center">Koniec</th>
                        <th scope="col" class="text-center">Uwagi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php //$data = []; 

                    // print_r($data);
                    // return null;
                    ?>
                    <?php foreach ($data as $row) :
                    ?>
                        <tr>
                            <th class="align-middle" scope="row"><?= $row['reservation_id']; ?></th>
                            <?php /* <td><?= $row['user_firstname'].' '.$row['user_lastname']; ?> (<?= $row['user_id']; ?>)</td> */ ?>
                            <td class="align-middle"><?= $row['user_firstname'].' '.$row['user_lastname'].'<br>'.$row['user_email']; ?></td>
                            <td class="align-middle"><?= $row['reservation_start_time']; ?></td>
                            <td class="align-middle"><?= $row['reservation_end_time']; ?></td>
                            <td class="align-middle"><?= $row['reservation_notes']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                        <?php if(!$data) : ?>
                        <tr>
                            <td colspan="5">Brak rezerwacji</td>
                        </tr>
                        <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    document.getElementById('month_picker').addEventListener('change', function() {
        document.getElementById('submit_button').click();
    });
</script>