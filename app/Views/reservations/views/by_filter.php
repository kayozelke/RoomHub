<!-- Title -->
<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <div class="">
        <p class="d-flex justify-content-between align-items-center my-1">
            <a type="button" class="btn btn-primary btn-sm m-1" href="/reservations"><i class="bi-arrow-left"></i></a>
            <span class="h3 text m-1 mx-2">Rezerwacje - wyszukiwanie</span>
        </p>
    </div>

    <div>
        <div class="d-flex align-items-center justify-content-between m-0 border-0 py-1 mb-1 me-1">
            <a type="button" class="btn btn-success bg-gradient m-0 me-1" href="/reservations/filter_settings?<?= http_build_query($current_query) ?>"><i class="bi-funnel"></i> Zmień filtry</a>
            <!-- <a type="button" class="btn btn-sm btn-secondary bg-gradient m-0 me-1" href="/reservations"><i class="bi-x-lg"></i> Wyczyść filtry</a> -->
        </div>
    </div>

</div>

<hr class="py-0 my-2">

<div class="my-4">

    <table class="table table-striped table-sm table-bordered text-center py-0" id="dataTable">
        <thead>
            <tr>
                <th scope="col" class="align-middle text-center">Nr rezerwacji</th>
                <th scope="col" class="align-middle text-center">Status rezerwacji</th>
                <th scope="col" class="align-middle text-center">Użytkownik</th>
                <!-- <th scope="col" class="align-middle text-center">Nr umowy</th> -->
                <th scope="col" class="align-middle text-center">Obiekt</th>
                <th scope="col" class="align-middle text-center">Pokój</th>
                <th scope="col" class="align-middle text-center">Miejsce</th>
                <th scope="col" class="align-middle text-center">Rozpoczęcie</th>
                <th scope="col" class="align-middle text-center">Zakończenie</th>
                <th scope="col" class="align-middle text-center">Opłata (PLN)</th>
                <th scope="col" class="align-middle text-center">Stan płatności</th>
                <th scope="col" class="align-middle text-center">Uwagi</th>
                <th scope="col" class="align-middle text-center">Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) :
            ?>
                <tr>
                    <th class="align-middle" scope="row"><?= $row['reservation_id']; ?></th>
                    <td class="align-middle">
                        <?= ($row['reservation_status'] == 0) ? 'zakończona' : (($row['reservation_status'] == 1) ? 'aktywna' : 'nierozpoczęta' ) ?>
                        <?php if ($row['reservation_deleted_at']) : ?>
                            <br>(archiwalna)
                        <?php endif ?>
                    </td>
                    <td class="align-middle">
                        <?= $row['user_firstname'] . ' ' . $row['user_lastname'] ?> <br>
                        <span class="fst-italic"><?= $row['user_email'] ?></span>
                    </td>
                    <?php /*<th class="align-middle" scope="row"><?= $row['reservation_contract_number']; ?></th>*/ ?>
                    <td class="align-middle"><?= $row['building_name']; ?></td>
                    <td class="align-middle"><?= $row['room_number']; ?></td>
                    <td class="align-middle"><?= $row['slot_name'] ?></td>
                    <td class="align-middle"><?= $row['reservation_start_time']; ?></td>
                    <td class="align-middle"><?= $row['reservation_end_time']; ?></td>
                    <td class="align-middle"><?= number_format($row['reservation_price'], 2, ",", "") ?></td>
                    <td class="align-middle"><?= ($row['reservation_payment_done'] == 0) ? "nieopłacona " : "opłacona"; ?></td>
                    <td class="align-middle"><?= esc($row['reservation_notes']); ?></td>
                    <td class="align-middle">
                        <?php if (!$row['reservation_deleted_at']) : ?>
                            <a href="/reservations/info/<?= $row['reservation_id']; ?>" class="btn btn-sm btn-secondary bg-gradient">
                                Zarządzaj
                            </a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
<?php if (isset($current_query['user_email']) && $current_query['user_email']) : ?>
    <script>
        document.getElementById('show_deleted').addEventListener('change', function() {
            document.getElementById('submit_button').click();
        });
    </script>
<?php endif ?>

<script type="module">
    // change container div placed at 'header.php'
    import * as my_module from '/assets/js/changeContainerClass.js';

    my_module.changeContainerClass('container-xxl', 'container-fluid');
</script>