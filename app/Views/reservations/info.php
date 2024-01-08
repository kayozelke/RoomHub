<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="d-flex justify-content-between align-items-center">
        <a type="button" class="btn btn-primary btn-sm m-1" href="/reservations"><i class="bi-arrow-left"></i></a>
        <span class="h3 text m-1 mx-2">Rezerwacja nr #<?= $current_reservation['reservation_id'] ?></span>
    </p>



    <p class="d-flex justify-content-between align-items-center">

        <?php if (session()->get('isModerator')) : ?>
            <!-- <a type="button" class="btn btn-warning m-1" href="#"><i class="bi-check2-square"></i> Potwierdź wpłatę czynszu</a> -->
            <a type="button" class="btn btn-secondary m-1" href="/reservations/edit/<?= $current_reservation['reservation_id'] ?>"><i class="bi-pencil-square"></i> Edytuj</a>
            <a type="button" class="btn btn-danger m-1" href="/reservations/delete_confirm/<?= $current_reservation['reservation_id'] ?>"><i class="bi-trash"></i> Kasuj</a>
        <?php endif; ?>

    </p>
</div>
<hr>

<div>
    <table class="table table-striped table-sm table-bordered text-center py-0">
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
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="align-middle" scope="current_reservation"><?= $current_reservation['reservation_id']; ?></th>

                <td class="align-middle">
                    <?= $current_reservation['reservation_status'] ?>
                    <?php if ($current_reservation['reservation_deleted_at']) : ?>
                        <br>(archiwalna)
                    <?php endif ?>
                </td>

                <td class="align-middle">
                    <a href="/users/info/<?= $current_reservation['user_id'] ?>"><?= $current_reservation['user_firstname'] . ' ' . $current_reservation['user_lastname'] ?></a> <br>
                    <span class="fst-italic"><?= $current_reservation['user_email'] ?></span>
                </td>
                <?php /* <th class="align-middle" scope="row"><?= $current_reservation['reservation_contract_number']; ?></th> */ ?>

                <td class="align-middle">
                    <a href="/buildings/info/<?= $current_reservation['building_id'] ?>">
                        <?= $current_reservation['building_name']; ?>
                    </a>
                </td>
                <td class="align-middle">
                    <a href="/rooms/info/<?= $current_reservation['room_id'] ?>">
                        <?= $current_reservation['room_number']; ?>
                    </a>
                </td>
                <td class="align-middle"><?= $current_reservation['slot_name'] ?></td>
                <td class="align-middle"><?= $current_reservation['reservation_start_time']; ?></td>
                <td class="align-middle"><?= $current_reservation['reservation_end_time']; ?></td>
                <td class="align-middle"><?= number_format($current_reservation['reservation_price'], 2, ",", "") ?></td>
                <td class="align-middle"><?= ($current_reservation['reservation_payment_done'] == 0) ? "nieopłacone " : "opłacone"; ?></td>
                <!-- <td></td> -->
                <td class="align-middle"><?= esc($current_reservation['reservation_notes']); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<hr>
<div class="d-flex justify-content-center">
    <?php if (session()->get('isModerator')) : ?>
        <?php if ($current_reservation['reservation_payment_done'] == 0) : ?>
            <a type="button" class="btn btn-success bg-gradient m-1" href="/reservations/edit/<?= $current_reservation['reservation_id'] ?>"><i class="bi-check2-square"></i> Potwierdź wpłatę czynszu</a>
        <?php endif; ?>
    <?php endif; ?>
    <a type="button" class="btn btn-primary bg-gradient m-1" href="#"><i class="bi-printer"></i> Pobierz podsumowanie PDF</a>
</div>

<?php /*if (session()->get('isModerator')) : ?>
<div class="d-flex justify-content-center">    
    </div>
<?php endif;*/ ?>