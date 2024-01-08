<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">

    <p class="d-flex justify-content-between align-items-center">
        <a type="button" class="btn btn-primary btn-sm m-1" href="/buildings/info/<?= $building['id'] ?>"><i class="bi-arrow-left"></i></a>
        <span class="h3 text m-1 mx-2">Pokoje - <?= $building['name'] ?></span>
    </p>
    <!-- <p class="h3 text">Pokoje - <?= $building['name'] ?></p> -->

    <?php if (session()->get('isModerator')) : ?>
        <a type="button" class="btn btn-success bg-gradient" href="/rooms/add/<?= $building['id'] ?>"><i class="bi-plus-lg"></i> Dodaj pokój</a>
    <?php endif; ?>

</div>
<hr>


<!-- <div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
        <p class="h5 text">Wybierz piętro</p>
    </div> -->
<div class="container p-2">

    <table class="table table-striped table-sm table-bordered text-center" id="dataTable">
        <thead>
            <tr>
                <?php if (session()->get('isModerator')) : ?>
                    <th scope="col" class="text-center">ID</th>
                <?php endif; ?>
                <th scope="col" class="text-center">Piętro</th>
                <th scope="col" class="text-center">Numer</th>
                <th scope="col" class="text-center">Typ pokoju</th>
                <th scope="col" class="text-center">Akcje</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($rooms as $row) : ?>
                <tr>
                    <?php if (session()->get('isModerator')) : ?>
                        <td><?= $row['room_id'] ?></td>
                    <?php endif; ?>
                    <td><?= $row['floor_eu'] ?></td>
                    <td><?= $row['number'] ?></td>
                    <td><?= $row['room_type_name'] ?></td>
                    <td>

                        <a href="/rooms/info/<?= $row['room_id']; ?>" class="btn btn-sm btn-primary bg-gradient">Przeglądaj</a>

                        <?php /* if (session()->get('isModerator')) : ?>
                            <a href="/roomtypes/edit/<?= $row['id']; ?>" class="btn btn-sm btn-secondary bg-gradient">Edytuj</a>
                            <a href="#<?= $row['id']; ?>" class="btn btn-sm btn-danger bg-gradient">Usuń</a>
                            <a href="#<?= $row['id']; ?>" class="btn btn-sm btn-secondary bg-gradient">Zarządzaj</a>
                        <?php endif; */ ?>
                    </td>
                </tr>

            <?php endforeach; ?>


        </tbody>
    </table>
</div>