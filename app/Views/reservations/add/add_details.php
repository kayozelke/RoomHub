<div class="row">
    <div class="col-12 col-lg-5 pt-3 pb-3  from-wrapper  d-flex align-items-center justify-content-center shadow">
        <div class="container bg-secondary-subtle border p-4">
            <h3>Nowa rezerwacja - okres najmu</h3>
            <hr>

            <div class="overflow-x-auto">
                <table class="table m-0">
                    <tbody>
                        <tr>
                            <td scope="row" class="fw-light">Użytkownik:</td>
                            <td class="text-end"><?= $current_user['firstname'] . ' ' . $current_user['lastname'] ?> (<?= $current_user['email'] ?>)</td>
                            <!-- <td class="text-end"></td> -->
                        </tr>
                        <tr>
                            <td scope="row" class="fw-light">Obiekt:</td>
                            <td class="text-end"><?= $current_building['name'] ?></td>
                        </tr>
                        <tr>
                            <td scope="row" class="fw-light">Pokój / miejsce:</td>
                            <td class="text-end"><?= $current_room['number'] ?> - <?= $current_slot['name'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>
            <form class="" method="get" action="/reservations/add_pricing">
                <input type="hidden" name="building_id" value="<?= $current_building['id'] ?>">
                <input type="hidden" name="room_number" value="<?= $current_room['number'] ?>">
                <input type="hidden" name="slot_id" value="<?= $current_slot['id'] ?>">
                <input type="hidden" name="user_email" value="<?= $current_user['email'] ?>">

                <h5>Określ długość najmu</h5>
                <div class="row">
                    <div class="col-12 col-sm-12 pt-1 pb-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="method" id="longReservationSelect" checked value="monthly" <?= (isset($current_query['method']) && $current_query['method'] == 'monthly') ? 'checked' : null ?>>
                            <label class="form-label" for="longReservationSelect"> Długookresowy (pełne miesiące najmu) </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="method" id="shortReservationSelect" value="daily" <?= (isset($current_query['method']) && $current_query['method'] == 'daily') ? 'checked' : null ?>>
                            <label class="form-check-label" for="shortReservationSelect"> Krótkookresowy (mniej niż miesiąc najmu) </label>
                        </div>
                    </div>
                </div>
                <hr>

                <div id="monthly_visible_only">
                    <!-- rules / monthly -->
                    <div class="row">
                        <div class="col-12 col-sm-12 pt-1 pb-1">
                            <ul>
                                <li>
                                    <span class="fw-light">Minimalna długość może najmu może wynosić 1 miesiąc. </span>
                                </li>
                                <li>

                                    <span class="fw-light">Maksymalna długość najmu może wynosić 12 miesięcy.</span>
                                </li>
                                <li>
                                    <span class="fw-light">Utworzona rezerwacja zostanie podzielona na poszczególne miesiące.</span>
                                </li>
                                <li>
                                    <span class="fw-light">Miesięczna opłata zostanie wyznaczona automatycznie według wybranego typu pokoju.</span>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="row align-items-center justify-content-center">
                        <div class="col-auto pt-1 pb-1">
                            <label for="m_start_date" class="form-label">Data rozpoczęcia</label>
                            <input class="form-control" type="date" name="m_start_date" id="m_start_date" value="<?= (isset($current_query['m_start_date'])) ? $current_query['m_start_date'] : null ?>">
                        </div>
                        <div class="col-auto pt-1 pb-1">
                            <label for="months_count" class="form-label">Liczba miesięcy</label>
                            <input class="form-control" type="number" name="months_count" id="months_count" min="1" max="12" value="<?= (isset($current_query['months_count'])) ? $current_query['months_count'] : 1 ?>">
                        </div>
                        <div class="col-auto pt-1 pb-1">
                            <label for="m_end_date" class="form-label">Data zakończenia</label>
                            <input readonly class="form-control bg-secondary" type="date" name="m_end_date" id="m_end_date">
                        </div>
                    </div>

                </div>

                <div id="daily_visible_only">
                    <!-- rules / daily -->
                    <div class="row">
                        <div class="col-12 col-sm-12 pt-1 pb-1">
                            <ul>
                                <li>
                                    <span class="fw-light">Minimalna długość może najmu może wynosić 1 dzień. </span>
                                </li>
                                <li>

                                    <span class="fw-light">Maksymalna długość najmu może być równa liczbie dni danego miesiąca.</span>
                                </li>
                                <li>
                                    <span class="fw-light">Wysokość opłaty należy wprowadzić ręcznie.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row align-items-center justify-content-center">
                        <div class="col-auto pt-1 pb-1">
                            <label for="start_date" class="form-label">Data rozpoczęcia</label>
                            <input class="form-control" type="date" name="start_date" id="start_date" value="<?= (isset($current_query['start_date'])) ? $current_query['start_date'] : null ?>">
                        </div>
                        
                        <div class="col-auto pt-1 pb-1">
                            <label for="end_date" class="form-label">Data zakończenia</label>
                            <input class="form-control" type="date" name="end_date" id="end_date" value="<?= (isset($current_query['end_date'])) ? $current_query['end_date'] : null ?>">
                        </div>
                    </div>

                </div>
                
                <div>
                    <div class="row">
                        <div class="col-12 col-sm-12 pt-1 pb-1">
                        <hr>
                            <ul>
                                <li>
                                    <span class="fw-light text-body-secondary">
                                        <em>Data rozpoczęcia</em> to pierwszy dzień rozliczenia. W praktyce najemca może wprowadzić się do miejsca najmu poprzedniego dnia (po określonej godzinie).
                                    </span>
                                </li>
                                <li>
                                    <span class="fw-light text-body-secondary">
                                        <em>Data zakończenia</em> to ostatni dzień rozliczenia. Tego dnia najemca musi wyprowadzić się z miejsca najmu do określonej godziny.
                                    </span>
                                </li>
                            </ul>
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
                <!-- Buttons -->
                <div class="row align-items-center">
                    <div class="col d-flex justify-content-start">
                        <a href="/reservations" class="btn btn-danger bg-gradient">Anuluj</a>
                        <a href="/reservations/add?<?= http_build_query($current_query) ?>" class="mx-1 btn btn-secondary bg-gradient">Wstecz</a>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button type="submit" class="btn btn-secondary bg-gradient">Dalej</button>
                        <button type="submit" class="btn btn-secondary bg-gradient" style="display:none" id="submit_reservation_details"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- current reservations view -->
    <div class="col-12 col-lg-7 pt-3 pb-3 from-wrapper d-flex align-items-center justify-content-center">
        <div class="container bg-primary-subtle bg-opacity-50 border p-4 overflow-x-auto shadow">
            <h4>Podgląd dostępności</h4>
            <?php /* <h3>Miejsce '<?= $current_slot['name'] ?>' w pokoju <?= $current_room['number'] ?></h3> */ ?>
            <hr>

            <?php /* */ ?>
            <?php //print_r(($current_query)); 
            ?>
            <div class="d-flex align-items-center justify-content-center m-0 border-0 py-2 mb-1 me-1">
                <!-- <div class="col-auto">
                </div> -->

                <div class="d-flex justify-content-between align-items-center">
                    <?php
                    # Building query arrays in this VIEW file
                    $query_previous_month = [
                        'user_email' => (isset($current_user['email']) && $current_user['email']) ? $current_user['email'] : null,
                        'building_id' => (isset($current_building['id']) && $current_building['id']) ? $current_building['id'] : null,
                        'room_number' => (isset($current_room['number']) && $current_room['number']) ? $current_room['number'] : null,
                        'slot_id' => (isset($current_slot['id']) && $current_slot['id']) ? $current_slot['id'] : null,
                        'year_month' => (new DateTime($filter_year_month))->modify('-1 month')->format('Y-m'),
                    ];
                    $query_next_month = [
                        'user_email' => (isset($current_user['email']) && $current_user['email']) ? $current_user['email'] : null,
                        'building_id' => (isset($current_building['id']) && $current_building['id']) ? $current_building['id'] : null,
                        'room_number' => (isset($current_room['number']) && $current_room['number']) ? $current_room['number'] : null,
                        'slot_id' => (isset($current_slot['id']) && $current_slot['id']) ? $current_slot['id'] : null,
                        'year_month' => (new DateTime($filter_year_month))->modify('+1 month')->format('Y-m'),
                    ];

                    ?>
                    <a type="button" class="btn btn-sm btn-primary bg-gradient m-0" href="?<?= http_build_query($query_previous_month) ?>"><i class="bi-chevron-double-left"></i></a>
                    <!-- <span class="m-0 mx-2 fw-bold"><?= $filter_year_month ?></span> -->
                    <form id="month_form" method="get" action="/reservations/add_details?<?= http_build_query($current_query) ?>">

                        <input type="hidden" name="building_id" value="<?= $current_building['id'] ?>">
                        <input type="hidden" name="room_number" value="<?= $current_room['number'] ?>">
                        <input type="hidden" name="slot_id" value="<?= $current_slot['id'] ?>">
                        <input type="hidden" name="user_email" value="<?= $current_user['email'] ?>">
                        <input class="m-0 mx-2 fw-bold" type="month" name="year_month" id="month_picker" value="<?= $filter_year_month ?>"></span>
                        <input type="submit" value="Submit" id="submit_month_button" style="display:none">
                        <!-- <input type="submit" value="Submit" id="submit_month_button" style=""> -->
                    </form>
                    <a type="button" class="btn btn-sm btn-primary bg-gradient m-0" href="?<?= http_build_query($query_next_month) ?>"><i class="bi-chevron-double-right"></i></a>

                </div>


            </div>

            <!-- <hr class="py-1 m-1"> -->

            <table class="table table-striped table-sm table-bordered text-center py-0" <?= ($data) ? 'id="dataTableSmall"' : null ?>>
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Nr</th>
                        <th scope="col" class="text-center">Użytkownik</th>
                        <!-- <th scope="col" class="text-center">Miejsce</th> -->
                        <th scope="col" class="text-center">Rozpoczęcie</th>
                        <th scope="col" class="text-center">Zakończenie</th>
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
                            <td class="align-middle"><?= $row['user_firstname'] . ' ' . $row['user_lastname'] . '<br>' . $row['user_email']; ?></td>
                            <td class="align-middle"><?= $row['reservation_start_time']; ?></td>
                            <td class="align-middle"><?= $row['reservation_end_time']; ?></td>
                            <td class="align-middle"><?= esc($row['reservation_notes']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$data) : ?>
                        <tr>
                            <td colspan="5">Brak najemców w wybranym czasie</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    // auto reload page (with submitting hidden form) when date changed at 'currrent reservations view'
    document.getElementById('month_picker').addEventListener('change', function() {
        document.getElementById('submit_month_button').click();
    });
</script>

<script>
    // switch do show / hide elements when picking element from radio checks
    var longReservationSelect = document.getElementById('longReservationSelect');
    var shortReservationSelect = document.getElementById('shortReservationSelect');
    var monthlyVisibleOnly = document.getElementById('monthly_visible_only');
    var dailyVisibleOnly = document.getElementById('daily_visible_only');

    function toggleVisibility() {
        monthlyVisibleOnly.style.display = longReservationSelect.checked ? 'block' : 'none';
        dailyVisibleOnly.style.display = shortReservationSelect.checked ? 'block' : 'none';
    }

    longReservationSelect.addEventListener('change', toggleVisibility);
    shortReservationSelect.addEventListener('change', toggleVisibility);

    toggleVisibility();
</script>


<script type="module">
    // change container div placed at 'header.php'
    import * as my_module from '/assets/js/changeContainerClass.js';

    my_module.changeContainerClass('container-xxl', 'container-fluid');
</script>


<script>
    // dynamic calculations of end-date when adding months
    document.addEventListener('DOMContentLoaded', function() {
        var startDate = document.getElementById('m_start_date');
        var monthsCount = document.getElementById('months_count');
        var endDate = document.getElementById('m_end_date');

        ['change', 'input'].forEach(function(evt) {

            startDate.addEventListener(evt, function() {
                updateEndDate(startDate, monthsCount, endDate);
            });

            monthsCount.addEventListener(evt, function() {
                updateEndDate(startDate, monthsCount, endDate);
            });

        });


        updateEndDate(startDate, monthsCount, endDate);

        function updateEndDate(start_date_element, months_count_element, end_date_element) {
            // console.log("TEST");
            var start_date_val = start_date_element.value;
            var months_count_val = months_count_element.value;

            if (start_date_val == "" || months_count_val == "") {
                return;
            }

            // AJAX fetching when building_id changed
            fetch('/calculate_end_date/' + start_date_val + '/' + months_count_val)
                .then(response => response.json())
                .then(data => {
                    end_date_element.value = data.end_date;
                })
                .catch(error => {

                    console.error('Error occured while getting endDate: ', error);
                    return;
                });





        };


    });
</script>