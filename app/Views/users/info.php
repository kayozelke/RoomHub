<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="d-flex justify-content-between align-items-center">
        <a type="button" class="btn btn-primary btn-sm m-1" href="/users"><i class="bi-arrow-left"></i></a>
        <span class="h3 text m-1 mx-2"><?= $data['firstname'] . ' ' . $data['lastname'] ?></span>
    </p>


    <p class="d-flex justify-content-between align-items-center">

        <?php if ($data['privileges_level'] > 0) : ?>
            <a type="button" class="btn btn-warning m-1" href="/users/decrease_privileges/<?= $data['id'] ?>"><i class="bi-person-gear"></i> Zmniejsz poziom uprawnień</a>
        <?php else : ?>
            <a type="button" class="btn btn-warning m-1" href="/users/increase_privileges/<?= $data['id'] ?>"><i class="bi-person-gear"></i> Podnieś poziom uprawnień</a>
        <?php endif; ?>


        <a type="button" class="btn btn-secondary m-1" href="/users/edit/<?= $data['id'] ?>"><i class="bi-pencil-square"></i> Edytuj</a>
        <a type="button" class="btn btn-danger m-1" href="/users/delete_confirm/<?= $data['id'] ?>"><i class="bi-trash"></i> Usuń</a>
    </p>
</div>

<hr>

<table class="table table-striped table-bordered text-center">
    <thead>
        <tr>
            <th scope="col" class="text-center">ID</th>
            <th scope="col" class="text-center">Email</th>
            <th scope="col" class="text-center">Imię</th>
            <th scope="col" class="text-center">Nazwisko</th>
            <th scope="col" class="text-center">Poziom uprawnień</th>
            <th scope="col" class="text-center">Utworzono</th>
            <th scope="col" class="text-center">Zmodyfikowano</th>
        </tr>
    </thead>
    <tbody>
        <?php //$data = []; 
        ?>
        <tr>
            <th scope="row"><?= $data['id']; ?></th>
            <td><?= $data['email']; ?></td>
            <td><?= $data['firstname']; ?></td>
            <td><?= $data['lastname']; ?></td>
            <td><?= $data['privileges_level_name']; ?></td>
            <td><?= $data['created_at']; ?></td>
            <td><?= $data['updated_at']; ?></td>

        </tr>
    </tbody>
</table>

<hr class="my-4">


<div class="d-flex justify-content-center align-items-center m-0 border-0 pt-4 pb-2">
    <div class="row">
        <div class="col-auto">
            <a href="/reservations/by_user?user_email=<?= $data['email'] ?>" class="btn btn-primary">Rezerwacje użytkownika</a>
        </div>
    </div>
</div>


<?php /* 
<table class="table table-striped table-sm table-bordered text-center" id="dataTableSmall">
    <thead>
        <tr>
            <th scope="col" class="align-middle text-center">Nr rezerwacji</th>
            <th scope="col" class="align-middle text-center">Użytkownik</th>
            <th scope="col" class="align-middle text-center">Nr umowy</th>
            <th scope="col" class="align-middle text-center">Obiekt</th>
            <th scope="col" class="align-middle text-center">Pokój</th>
            <th scope="col" class="align-middle text-center">Miejsce</th>
            <th scope="col" class="align-middle text-center">Rozpoczęcie</th>
            <th scope="col" class="align-middle text-center">Zakończenie</th>
            <th scope="col" class="align-middle text-center">Opłata (PLN)</th>
            <th scope="col" class="align-middle text-center">Status</th>
            <th scope="col" class="align-middle text-center">Uwagi</th>
            <th scope="col" class="align-middle text-center">Akcje</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($user_reservations as $row) : ?>
            <tr>
                <th class="align-middle" scope="row"><?= $row['reservation_id']; ?></th>
                <td><?= $row['user_firstname'].' '.$row['user_lastname']; ?> (<?= $row['user_id']; ?>)</td>
                <td class="align-middle">
                    <?= $row['user_firstname'] . ' ' . $row['user_lastname'] ?> <br>
                    <span class="fst-italic"><?= $row['user_email'] ?></span>
                </td>
                <th class="align-middle" scope="row"><?= $row['reservation_contract_number']; ?></th>
                <td class="align-middle"><?= $row['building_name']; ?></td>
                <td class="align-middle"><?= $row['room_number']; ?></td>
                <td class="align-middle"><?= $row['slot_name'] ?></td>
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
        <?php endforeach ?>
    </tbody>
</table>
 */ ?>

<!-- <div class="mt-5">
    <a type="button" class="btn btn-primary btn-sm mt-5" href="/users"><i class="bi-arrow-left"></i></a>
</div> -->