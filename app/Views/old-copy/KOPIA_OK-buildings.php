<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Hello, <?= session()->get('firstname') ?></h1>


            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
            <?php
            print_r($data)
            ?>
            <hr>


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
                            <td><?= $row['address']; ?></td>
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
</div>