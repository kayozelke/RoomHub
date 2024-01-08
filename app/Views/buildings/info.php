<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">

    <p class="d-flex justify-content-between align-items-center">
        <a type="button" class="btn btn-primary btn-sm m-1" href="/buildings"><i class="bi-arrow-left"></i></a>
        <span class="h3 text m-1 mx-2"><?= $current_building_info['name'] ?></span>
    </p>
    <!-- <p class="h2 text"><?= $current_building_info['name'] ?></p> -->
    <p class="d-flex justify-content-between align-items-center">

        <?php if (session()->get('isModerator')) : ?>
            <a type="button" class="btn btn-secondary m-1" href="/buildings/edit/<?= $current_building_info['id'] ?>"><i class="bi-pencil-square"></i> Edytuj</a>
            <a type="button" class="btn btn-danger m-1" href="/buildings/delete_confirm/<?= $current_building_info['id'] ?>"><i class="bi-trash"></i> Kasuj</a>
        <?php endif; ?>

    </p>
</div>
<hr>

<div class="d-flex justify-content-center align-items-center m-0 border-0 pt-1">
    <!-- Address -->
    <p class="d-flex"><i class="bi bi-geo-alt-fill mx-2"></i><?= $current_building_info['address'] ?></p>
</div>

<!-- Description -->
<?php if ($current_building_info['description']) : ?>
    <div class="m-0 border-0 pt-0 px-1">
        <div class="rounded border p-3 shadow">
            <p class=""><?= $current_building_info['description'] ?></p>
        </div>
    </div>
<?php endif ?>



<!-- Rooms card -->
<div class="row p-3 d-flex justify-content-center">
    <div class="col-12 card py-3 hover-zoom shadow">
        <a href="/rooms/by_building/<?= $current_building_info['id'] ?>" class="text-decoration-none text-white">
            <div class="bg-image d-flex justify-content-center align-items-center room-card">
                <h1>Przegląd pokoi</h1>
            </div>
        </a>
    </div>
</div>




<?php if (session()->get('isModerator')) : ?>
    <!-- <hr> -->
    <div class="row mb-4 d-flex justify-content-center">
        <div class="col-12 col-lg-6 p-2 mb-4">
            <div class="overflow-x-auto border rounded">
                <table class="table table-sm table-transparent <? //table-bordered
                                                                ?> m-0">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center align-middle">Liczba pokoi</th>
                            <th scope="col" class="text-center align-middle">Wszystkie miejsca</th>
                            <th scope="col" class="text-center align-middle">Dostępne miejsca</th>
                            <th scope="col" class="text-center align-middle">Zajęte miejsca</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center align-middle"><?= $current_building_rooms_count ?></td>
                            <td class="text-center align-middle"><?= $current_building_slots_count ?></td>
                            <td class="text-center align-middle"><?= $current_building_slots_count - $current_building_reservations_today_count ?></td>
                            <td class="text-center align-middle"><?= $current_building_reservations_today_count ?></td>
                        </tr>

                        <tr>
                            <td scope="row" class="fw-light text-center align-middle" colspan="3">
                                <div class="progress m-3" role="progressbar" style="height: 30px; min-width:350px">
                                    <?php
                                    if ($current_building_slots_count == 0)
                                        $fill_percent = 0;
                                    else
                                        $fill_percent = intval(($current_building_reservations_today_count / $current_building_slots_count) * 100);

                                    $color_class = "bg-success";

                                    if ($fill_percent >= 60)
                                        $color_class = "bg-warning";

                                    if ($fill_percent >= 90)
                                        $color_class = "bg-danger";
                                    ?>
                                    <div class="progress-bar progress-bar-striped <?= $color_class ?>" style="width: <?= $fill_percent ?>%"></div>
                                </div>
                            </td>
                            <td class="text-center align-middle"><?= $fill_percent ?>% zajętych miejsc</td>
                        </tr>
                    </tbody>
                </table>
            </div>




        </div>
        <!-- 
    <div class="col-12 col-lg-6">
        <div class="progress my-1" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success py-2" style="width: 25%">25%</div>
        </div>
        <div class="progress my-1" role="progressbar" aria-label="Info example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-info text-dark progress-bar-striped" style="width: 50%">50%</div>
        </div>
        <div class="progress my-1" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-warning text-dark" style="width: 75%">75%</div>
        </div>
        <div class="progress my-1" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-danger" style="width: 100%">100%</div>

        </div>
    </div> -->

    </div>
<?php endif; ?>