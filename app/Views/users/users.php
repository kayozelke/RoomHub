<?php

    // Multiplying data for testing
    $copy_number = 1;

    for ($i = 0; $i < $copy_number; $i++) {
        foreach ($data as $row) {
            $multiplied_data[] = $row;
        }
    }
    $data = $multiplied_data;
?>

<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h3 text">Użytkownicy</p>

    <?php /* if (session()->get('isModerator')) : ?>
        <a type="button" class="btn btn-success bg-gradient" href="#"><i class="bi-plus-lg"></i> Dodaj konto</a>
    <?php endif; */ ?>

</div>
<hr>

<table class="table table-striped table-sm table-bordered text-center" id="dataTable">
    <thead>
        <tr>
            <th scope="col" class="text-center">ID</th>
            <th scope="col" class="text-center">Email</th>
            <th scope="col" class="text-center">Imię</th>
            <th scope="col" class="text-center">Nazwisko</th>
            <th scope="col" class="text-center">Poziom uprawnień</th>
            <th scope="col" class="text-center">Utworzono</th>
            <th scope="col" class="text-center">Zmodyfikowano</th>
            <th scope="col" class="text-center">Akcje</th>
        </tr>
    </thead>
    <tbody>
        <?php //$data = []; 
        ?>
        <?php foreach ($data as $row) : ?>
            <tr>
                <th scope="row"><?= $row['id']; ?></th>
                <td><?= $row['email']; ?></td>
                <td><?= $row['firstname']; ?></td>
                <td><?= $row['lastname']; ?></td>
                <td><?= $row['privileges_level_name']; ?></td>
                <td><?= $row['created_at']; ?></td>
                <td><?= $row['updated_at']; ?></td>
                <td>
                    <a href="/users/info/<?= $row['id']; ?>" class="btn btn-sm btn-secondary bg-gradient">Zarządzaj</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

