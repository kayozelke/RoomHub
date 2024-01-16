<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h3 text">Rezerwacje - panel użytkownika</p>

    <!-- <a type="button" class="btn btn-success bg-gradient" href="/reservations/add"><i class="bi-plus-lg"></i> Nowa rezerwacja</a> -->

</div>
<hr class="py-0 my-2">



<?php
if (isset($unpaid_reservations))  $number = count($unpaid_reservations);
else $number = 0;
?>

<!-- <div class="d-flex align-items-center m-0 border-0 pt-4 pb-2"> -->
<div class="row m-0 border-0 pt-4 pb-2">
    <div class="col-12 <?= ($number > 0) ? 'col-lg-4' : null ?> d-flex align-items-center">
        <!-- <p>Lista Twoich rezerwacji</p> -->
        <div>
            <?php if (isset($current_reservation) && $current_reservation) : ?>
                <p class="d-flex"><i class="bi bi-house mx-2"></i>Mieszkasz w pokoju nr <?= $current_reservation['room_number'] ?>.</p>
            <?php else : ?>
                <p class="d-flex"><i class="bi bi-house-slash mx-2"></i>W tej chwili nie wynajmujesz żadnego pokoju.</p>
            <?php endif ?>

            <?php if ($number > 0) : ?>
                <?php if ($number == 1) : ?>
                    <!-- <p class="fw-bold text-danger">Zalegasz z 1 opłatą czynszu!</p> -->
                    <p class="d-flex fw-bold text-danger-emphasis"><i class="bi bi-exclamation-triangle-fill mx-2"></i>Zalegasz z 1 opłatą czynszu!</p>
                <?php else :   ?>
                    <!-- <p class="fw-bold text-danger">Zalegasz z <?= $number ?> opłatami czynszu!</p> -->
                    <p class="d-flex fw-bold text-danger"><i class="bi bi-exclamation-circle-fill mx-2"></i>Zalegasz z <?= $number ?> opłatami czynszu!</p>
                <?php endif ?>
            <?php else : ?>
                <p class="d-flex"><i class="bi bi-check-circle-fill mx-2"></i>Wszystkie opłaty za czynsz zostały uregulowane.</p>
            <?php endif ?>
        </div>
    </div>

    <?php if ($number > 0) : ?>
        <div class="col-12 col-lg-8">
            <table class="table table-striped table-sm table-bordered text-center" id="dataTableSmall">
                <thead>
                    <tr>
                        <th scope="col" class="align-middle text-center">Nr rezerwacji</th>
                        <th scope="col" class="align-middle text-center">Rozpoczęcie</th>
                        <th scope="col" class="align-middle text-center">Zakończenie</th>
                        <th scope="col" class="align-middle text-center">Opłata (PLN)</th>
                        <th scope="col" class="align-middle text-center">Stan płatności</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($unpaid_reservations as $row) : ?>
                        <tr>
                            <th class="align-middle" scope="row"><?= $row['reservation_id']; ?></th>
                            <td class="align-middle"><?= $row['reservation_start_time']; ?></td>
                            <td class="align-middle"><?= $row['reservation_end_time']; ?></td>
                            <td class="align-middle"><?= number_format($row['reservation_price'], 2, ",", "") ?></td>
                            <td class="align-middle"><?= ($row['reservation_payment_done'] == 0) ? "nieopłacone " : "opłacone"; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</div>
<!-- </div> -->



<hr class="py-0 my-2">

<div class="d-flex justify-content-start align-items-center m-0 border-0 pt-2">
    <!-- <div class="d-flex align-items-center m-0 border-0 pt-4 pb-2"> -->
    <div class="row">
        <div class="col-auto">
            <!-- <p>Lista Twoich rezerwacji</p> -->
            <p class="fw-bold h5">Twoje rezerwacje</p>
        </div>
    </div>
</div>


<div class="d-flex align-items-center justify-content-between m-0 border-0 py-1 mb-1 me-1">
    <div class="col-12 col-sm-6">
        <?php /*
            <a type="button" class="btn btn-sm btn-primary bg-gradient m-0 me-1" href="/reservations/filtering?<?= http_build_query($current_query) ?>"><i class="bi-funnel"></i> Filtruj</a>
        */ ?>
        <?php if (isset($isFilterEnabled) && $isFilterEnabled == true) : ?>
            <a type="button" class="btn btn-sm btn-secondary bg-gradient m-0 me-1" href="/reservations"><i class="bi-x-lg"></i> Wyczyść filtr</a>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <?php
        # Building query arrays in this VIEW file
        $query_previous_month = [
            'year_month' => (new DateTime($filter_year_month))->modify('-1 month')->format('Y-m'),
        ];
        $query_next_month = [
            'year_month' => (new DateTime($filter_year_month))->modify('+1 month')->format('Y-m'),
        ];

        ?>
        <a type="button" class="btn btn-sm btn-primary bg-gradient m-0" href="?<?= http_build_query($query_previous_month) ?>"><i class="bi-chevron-double-left"></i></a>
        <form class="" id="month_form" method="get" action="?<?= http_build_query($current_query) ?>">
            <div class="mx-1">
                <input class="m-0 mx-2 form-control py-1 w-auto" type="month" name="year_month" id="month_picker" value="<?= $filter_year_month ?>"></span>
                <input type="submit" value="Submit" id="submit_button" style="display:none">
            </div>
        </form>
        <a type="button" class="btn btn-sm btn-primary bg-gradient m-0" href="?<?= http_build_query($query_next_month) ?>"><i class="bi-chevron-double-right"></i></a>

    </div>


</div>


<table class="table table-striped table-sm table-bordered text-center" id="dataTable">
    <thead>
        <tr>
            <th scope="col" class="align-middle text-center">Nr rezerwacji</th>
            <th scope="col" class="align-middle text-center">Status rezerwacji</th>
            <th scope="col" class="align-middle text-center">Obiekt</th>
            <th scope="col" class="align-middle text-center">Pokój</th>
            <th scope="col" class="align-middle text-center">Miejsce</th>
            <th scope="col" class="align-middle text-center">Rozpoczęcie</th>
            <th scope="col" class="align-middle text-center">Zakończenie</th>
            <th scope="col" class="align-middle text-center">Opłata (PLN)</th>
            <th scope="col" class="align-middle text-center">Stan płatności</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($user_reservations as $row) : ?>
            <tr>
                <th class="align-middle" scope="row"><?= $row['reservation_id']; ?></th>
                <td class="align-middle">
                    <?= ($row['reservation_status'] == 0) ? 'zakończona' : (($row['reservation_status'] == 1) ? 'aktywna' : 'nierozpoczęta') ?>
                    <?php if ($row['reservation_deleted_at']) : ?>
                        <br>(archiwalna)
                    <?php endif ?>
                </td>
                <td class="align-middle"><?= $row['building_name']; ?></td>
                <td class="align-middle"><?= $row['room_number']; ?></td>
                <td class="align-middle"><?= $row['slot_name'] ?></td>
                <td class="align-middle"><?= $row['reservation_start_time']; ?></td>
                <td class="align-middle"><?= $row['reservation_end_time']; ?></td>
                <td class="align-middle"><?= number_format($row['reservation_price'], 2, ",", "") ?></td>
                <td class="align-middle"><?= ($row['reservation_payment_done'] == 0) ? "nieopłacona " : "opłacona"; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>


<script>
    document.getElementById('month_picker').addEventListener('change', function() {
        document.getElementById('submit_button').click();
    });
</script>