<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h3 text">Nasze obiekty</p>
    <?php if (session()->get('isModerator')) : ?>
        <a type="button" class="btn btn-success bg-gradient" href="/buildings/add"><i class="bi-plus-lg"></i> Dodaj obiekt</a>
    <?php endif; ?>
</div>
<hr>

<?php
$iteration = 0;
foreach ($data as $row) : ?>
    <?php if (!($iteration % 2)) : ?>
        <div class="row mx-0 px-0">
        <?php endif ?>
        <div class="col-12 col-md-6 my-0 py-2 py-3">
            <div class="row px-3 py-1">
                <div class="col-12 card py-3 shadow hover-zoom">
                    <a href="/buildings/info/<?= $row['id'] ?>" class="text-decoration-none text-white">
                        <div class="bg-image d-flex justify-content-center align-items-center custom-card bg-img-building">
                            <div class="row p-1">
                                <div class="col">
                                    <h3 class="text-center"><?= $row['name'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <?php /* <div class="d-flex justify-content-center align-items-center m-0 border-0 p-1">
                <p class="d-flex fst-italic align-items-center px-1 py-0 m-0"><?= $row['address'] ?></p>
                <p class="d-flex justify-content-between align-items-center p-0 m-0">
                    <a type="button" class="btn btn-secondary bg-gradient my-0 mx-1" href="/buildings/info/<?= $row['id'] ?>"><i class="bi-info-square"></i> Informacje</a>
                    <a type="button" class="btn btn-primary bg-gradient my-0 ms-1" href="rooms/by_building/<?= $row['id'] ?>"><i class="bi-door-closed"></i> Pokoje</a>
                </p>
            </div> */ ?>

            <div class="d-flex justify-content-center align-items-center my-0 mx-1 p-1">
                <!-- <p class="d-flex justify-content-between align-items-center p-0 m-0"> -->
                <a type="button" class="btn btn-secondary bg-gradient my-0 mx-1" href="/buildings/info/<?= $row['id'] ?>"><i class="bi-info-square"></i> Informacje</a>
                <a type="button" class="btn btn-primary bg-gradient my-0 ms-1" href="rooms/by_building/<?= $row['id'] ?>"><i class="bi-door-closed"></i> Pokoje</a>
                <!-- </p> -->
            </div>

            <!-- <hr class="my-1"> -->
        </div>

        <?php if ($iteration % 2) : ?>
        </div>
    <?php endif ?>
<?php $iteration++;
endforeach;

if (!$data) { ?>
    <h5 class="text-center align-items-center p-0 m-0">Brak danych</h5>

<?php
} ?>







<?php /*
        <div class="row">
            <div class="col-12">
                <div class="container pt-1"> </div>   
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Adres</th>
                            <th scope="col">Nazwa</th>
                            <th scope="col">Utworzono</th>
                            <th scope="col">Zmodyfikowano</th>
                            <th scope="col">Notatki</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) : ?>
                            <tr>
                                <th scope="row"><?= $row['id']; ?></th>
                                <td><?= $row['address']?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['created_at']; ?></td>
                                <td><?= $row['updated_at']; ?></td>
                                <td><?= $row['notes']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
    
    
    
            </div>
        </div>
    */ ?>

<!-- <img class="img-fluid" src="/assets/images/dormitory/building-1.jpg" alt=""> -->