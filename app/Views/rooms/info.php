<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="d-flex justify-content-between align-items-center">
        <a type="button" class="btn btn-primary btn-sm m-1" href="/rooms/by_building/<?= $building_data['id'] ?>"><i class="bi-arrow-left"></i></a>
        <span class="h3 text m-1 mx-2">Pokój <?= $room_data['number'] . ' - ' . $building_data['name'] ?></span>
    </p>
    <p class="d-flex justify-content-between align-items-center">


        <?php if (session()->get('isModerator')) : ?>
            <a type="button" class="btn btn-secondary m-1" href="/rooms/edit/<?= $room_data['id'] ?>"><i class="bi-pencil-square"></i> Edytuj</a>
            <a type="button" class="btn btn-danger m-1" href="/rooms/delete_room_confirm/<?= $room_data['id'] ?>"><i class="bi-trash"></i> Usuń</a>
        <?php endif; ?>


    </p>
</div>
<hr>

<table class="table table-striped table-bordered text-center my-4">
    <thead>
        <tr>
            <?php if (session()->get('isModerator')) : ?>
                <th scope="col" class="text-center align-middle">ID</th>
            <?php endif; ?>
            <th scope="col" class="text-center align-middle">Numer</th>
            <th scope="col" class="text-center align-middle">Obiekt</th>
            <th scope="col" class="text-center align-middle">Piętro</th>
            <th scope="col" class="text-center align-middle">Typ pokoju</th>
            <th scope="col" class="text-center align-middle">Liczba miejsc</th>
            <th scope="col" class="text-center align-middle">Miesięczny czynsz</th>
            <?php if (session()->get('isModerator')) : ?>
                <th scope="col" class="text-center align-middle">Dodano</th>
                <th scope="col" class="text-center align-middle">Zmodyfikowano</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php if (session()->get('isModerator')) : ?>
                <th scope="row" class="text-center align-middle"><?= $room_data['id']; ?></th>
            <?php endif; ?>
            <td class="text-center align-middle"><?= $room_data['number']; ?></td>
            <td class="text-center align-middle"><?= $building_data['name']; ?></td>
            <td class="text-center align-middle"><?= $room_data['floor_eu']; ?></td>
            <td class="text-center align-middle"><?= $room_type_data['name']; ?></td>
            <td class="text-center align-middle"><?= $room_type_data['max_residents']; ?></td>
            <td class="text-center align-middle"><?= $room_type_data['price_month']; ?> PLN</td>
            <?php if (session()->get('isModerator')) : ?>
                <td class="text-center align-middle"><?= $room_data['created_at']; ?></td>
                <td class="text-center align-middle"><?= $room_data['updated_at']; ?></td>
            <?php endif; ?>

        </tr>
    </tbody>
</table>


<hr class="my-4">

<div class="d-flex justify-content-between align-items-center m-0 border-0 py-2">
    <p class="h4 text">Miejsca</p>
    <?php if (session()->get('isModerator')) : ?>
        <a type="button" class="btn btn-success bg-gradient m-0" href="/rooms/<?= $room_data['id'] ?>/add_slot"><i class="bi-plus-lg"></i> Dodaj miejsce</a>
    <?php endif; ?>
</div>

<table class="table table-striped table-sm table-bordered text-center">
    <thead>
        <tr>
            <?php if (session()->get('isModerator')) : ?>
                <th scope="col" class="text-center align-middle">ID</th>
            <?php endif; ?>
            <th scope="col" class="text-center align-middle">Opis</th>
            <th scope="col" class="text-center align-middle">Stan</th>
            <?php if (session()->get('isModerator')) : ?>
                <th scope="col" class="text-center align-middle">Akcje</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($slots_data as $row) : ?>
            <tr>
                <?php if (session()->get('isModerator')) : ?>
                    <td class="text-center align-middle"><?= $row['id']; ?></td>
                <?php endif; ?>
                <td class="text-center align-middle"><?= $row['name']; ?></td>
                <td class="text-center align-middle">
                    <a href="/reservations/by_filter?building_id=<?= $building_data['id'] ?>&room_number=<?= $room_data['number'] ?>">
                        <?php if ($row['isFree'] == true) : ?>
                            Wolne
                            <?php if ($row['nextStartDate']) : ?>
                                do <?= $row['nextStartDate'] ?>
                                <?php //else : 
                                ?>
                                <!-- (brak rezerwacji) -->
                            <?php endif; ?>
                        <?php else : ?>
                            Zajęte do <?= $row['nextEndDate'] ?>
                        <?php endif; ?>
                    </a>
                </td>
                <?php if (session()->get('isModerator')) : ?>
                    <td class="text-center align-middle">
                        <!-- <a href="#" class="btn btn-sm btn-primary bg-gradient">Zarezerwuj</a> -->
                        <a href="/rooms/<?= $room_data['id'] ?>/add_slot/<?= $row['id']; ?>" class="btn btn-sm btn-secondary bg-gradient">Edytuj</a>
                        <a href="/rooms/delete_slot_confirm/<?= $row['id']; ?>" class="btn btn-sm btn-danger bg-gradient">Usuń</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach;
        if (!$slots_data) : ?>
            <td colspan="4">Brak danych</td>
        <?php endif; ?>
    </tbody>
</table>

<?php
// foreach($slots_data as $row){
//     print_r($row);
//     echo "<br>";
// }
?>