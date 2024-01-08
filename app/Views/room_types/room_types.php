<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h3 text">Rodzaje pokoi</p>

    <?php if (session()->get('isModerator')) : ?>
        <a type="button" class="btn btn-success bg-gradient" href="/roomtypes/add"><i class="bi-plus-lg"></i> Dodaj nowy</a>
    <?php endif; ?>

</div>
<hr>

<?php
//print_r($data);
?>


<div class="container mt-4">
    <table class="table table-striped table table-bordered text-center" id="dataTable">
        <thead>
            <tr>
                <?php if (session()->get('isModerator')) : ?>
                    <th scope="col" class="text-center">ID</th>
                <?php endif; ?>
                <th scope="col" class="text-center">Nazwa</th>
                <th scope="col" class="text-center">Liczba lokatorów</th>
                <th scope="col" class="text-center">Miesięczny czynsz (PLN)</th>
                <?php if (session()->get('isModerator')) : ?>
                    <th scope="col" class="text-center">Akcje</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $row) :
            ?>
                <tr>
                    <?php if (session()->get('isModerator')) : ?>
                        <?php /* */ ?>
                        <th scope="row"><?= $row['id']; ?></th>
                    <?php endif; ?>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['max_residents'] ?></td>
                    <td><?= number_format($row['price_month'], 2, ",", ""); ?></td>

                    <?php if (session()->get('isModerator')) : ?>
                        <td class="text-center">
                            <?php /* <a href="#<?= $row['id']; ?>" class="btn btn-sm btn-primary bg-gradient">Zarezerwuj</a> */ ?>
                            <a href="/roomtypes/edit/<?= $row['id']; ?>" class="btn btn-sm btn-secondary bg-gradient">Edytuj</a>
                            <a href="/roomtypes/delete_confirm/<?= $row['id']; ?>" class="btn btn-sm btn-danger bg-gradient">Usuń</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>