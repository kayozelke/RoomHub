<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h3 text">Rezerwacje - panel administracyjny</p>

    <a type="button" class="btn btn-success bg-gradient" href="/reservations/add"><i class="bi-plus-lg"></i> Nowa rezerwacja</a>

</div>
<hr class="py-0 my-2">
<div class="d-flex align-items-center justify-content-between m-0 border-0 py-1 mb-1 me-1">
    <div class="col-12 col-sm-6">
        <a type="button" class="btn btn-sm btn-primary bg-gradient m-0 me-1" href="/reservations/filtering?<?= http_build_query($current_query) ?>"><i class="bi-funnel"></i> Filtruj</a>
        <?php if (isset($isFilterEnabled) && $isFilterEnabled == true) : ?>
            <a type="button" class="btn btn-sm btn-secondary bg-gradient m-0 me-1" href="/reservations"><i class="bi-x-lg"></i> Wyczyść filtry</a>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <?php
        # Building query arrays in this VIEW file
        $query_previous_month = [
            'user_email' => (isset($filter_user_email_fragment) && $filter_user_email_fragment) ? $filter_user_email_fragment : null,
            'building_id' => (isset($filter_building_id) && $filter_building_id) ? $filter_building_id : null,
            'number' => (isset($filter_room_number_fragment) && $filter_room_number_fragment) ? $filter_room_number_fragment : null,
            'year_month' => (new DateTime($filter_year_month))->modify('-1 month')->format('Y-m'),
        ];
        $query_next_month = [
            'user_email' => (isset($filter_user_email_fragment) && $filter_user_email_fragment) ? $filter_user_email_fragment : null,
            'building_id' => (isset($filter_building_id) && $filter_building_id) ? $filter_building_id : null,
            'number' => (isset($filter_room_number_fragment) && $filter_room_number_fragment) ? $filter_room_number_fragment : null,
            'year_month' => (new DateTime($filter_year_month))->modify('+1 month')->format('Y-m'),
        ];

        ?>
        <a type="button" class="btn btn-sm btn-primary bg-gradient m-0" href="?<?= http_build_query($query_previous_month) ?>"><i class="bi-chevron-double-left"></i></a>
        <?php /* <input class="m-0 mx-1 form-control form-control-sm text=center" type="month" value="<?=$filter_year_month?>" disabled> */ ?>
        <!-- <span class="m-0 mx-2 fw-bold"><?= $filter_year_month ?></span> -->

        <form class="" id="month_form" method="get" action="?<?= http_build_query($current_query) ?>">
            <input type="hidden" name="user_email" value="<?=(isset($filter_user_email_fragment) && $filter_user_email_fragment) ? $filter_user_email_fragment : null?>">
            <input type="hidden" name="building_id" value="<?= (isset($filter_building_id) && $filter_building_id) ? $filter_building_id : null ?>">
            <input type="hidden" name="number" value="<?= (isset($filter_room_number_fragment) && $filter_room_number_fragment) ? $filter_room_number_fragment : null ?>">
            <input class="m-0 mx-2" type="month" name="year_month" id="month_picker" value="<?= $filter_year_month ?>"></span>
            <input type="submit" value="Submit" id="submit_button" style="display:none">
        </form>
        <a type="button" class="btn btn-sm btn-primary bg-gradient m-0" href="?<?= http_build_query($query_next_month) ?>"><i class="bi-chevron-double-right"></i></a>

    </div>


</div>

<!-- <hr class="py-1 m-1"> -->

<table class="table table-striped table-sm table-bordered text-center py-0" id="dataTable">
    <thead>
        <tr>
            <th scope="col" class="align-middle text-center">Nr</th>
            <th scope="col" class="align-middle text-center">Użytkownik</th>
            <th scope="col" class="align-middle text-center">Obiekt</th>
            <th scope="col" class="align-middle text-center">Pokój</th>
            <!-- <th scope="col" class="align-middle text-center">Miejsce</th> -->
            <th scope="col" class="align-middle text-center">Rozpoczęcie</th>
            <th scope="col" class="align-middle text-center">Zakończenie</th>
            <th scope="col" class="align-middle text-center">Opłata (PLN)</th>
            <th scope="col" class="align-middle text-center">Status</th>
            <th scope="col" class="align-middle text-center">Uwagi</th>
            <th scope="col" class="align-middle text-center">Akcje</th>
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
                <td class="align-middle">
                    <?= $row['user_firstname'] . ' ' . $row['user_lastname'] ?> <br>
                    <span class="fst-italic"><?= $row['user_email'] ?></span>
                </td>
                <td class="align-middle"><?= $row['building_name']; ?></td>
                <td class="align-middle"><?= $row['room_number']; ?></td>
                <!-- <td><?= $row['slot_name'] ?> (<?= $row['slot_id']; ?>)</td> -->
                <td class="align-middle"><?= $row['reservation_start_time']; ?></td>
                <td class="align-middle"><?= $row['reservation_end_time']; ?></td>
                <td class="align-middle"><?= number_format($row['reservation_price'], 2, ",", "") ?></td>
                <td class="align-middle"><?= ($row['reservation_payment_done'] == 0) ? "nieopłacone " : "opłacone"; ?></td>
                <!-- <td></td> -->
                <td class="align-middle"><?= esc($row['reservation_notes']); ?></td>
                <td class="align-middle">
                    <a href="/reservations/info/<?= $row['reservation_id']; ?>" class="btn btn-sm btn-secondary bg-gradient">Zarządzaj</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script>
    document.getElementById('month_picker').addEventListener('change', function() {
        document.getElementById('submit_button').click();
    });
</script>

<script type="module">
    // change container div placed at 'header.php'
    import * as my_module from '/assets/js/changeContainerClass.js';

    my_module.changeContainerClass('container-xxl', 'container-fluid');
</script>