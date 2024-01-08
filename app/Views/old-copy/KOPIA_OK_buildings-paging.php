<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="container pt-1"> </div>

            <?php

            // Dane

            // $data = [
            //     ['id' => 1, 'address' => '806 Johns Landing Apt. 144 New Randall, UT 12244', 'name' => 'moniuszka', 'created_at' => '2023-12-19 11:55:27', 'updated_at' => '2023-12-19 11:55:28', 'notes' => ''],
            //     ['id' => 2, 'address' => '60892 Henriette Avenue Apt. 251 South Conor, RI 88031-3281', 'name' => 'jowita', 'created_at' => '2023-12-19 11:55:27', 'updated_at' => '2023-12-19 11:55:28', 'notes' => '']
            // ];

            // // Ilość kopii
            // $ilosc_kopii = 200;

            // // Powielanie danych
            // for ($i = 0; $i < $ilosc_kopii; $i++) {
            //     foreach ($data as $row) {
            //         $dane_powielone[] = $row;
            //     }
            // }
            // $data=$dane_powielone;

            // Liczba rekordów na stronie
            $recordsPerPage = 3;

            // Numer aktualnej strony
            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

            // Oblicz indeks początkowy dla aktualnej strony
            $startIndex = ($currentPage - 1) * $recordsPerPage;

            // Pobierz tylko rekordy dla aktualnej strony
            $currentPageData = array_slice($data, $startIndex, $recordsPerPage);

            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Adres</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Utworzono</th>
                        <th scope="col">Zmodyfikowano</th>
                        <th scope="col">Uwagi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($currentPageData as $row) : ?>
                        <tr>
                            <th scope="row"><a href=""><?= $row['id']; ?></a></th>
                            <td><?= $row['address']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['created_at']; ?></td>
                            <td><?= $row['updated_at']; ?></td>
                            <td><?= $row['notes']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Paginacja -->

            <?php /*
            <div class="pagination">
                <?php
                $totalPages = ceil(count($data) / $recordsPerPage);
                for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <a href="?page=<?= $i; ?>" <?= ($i == $currentPage) ? ' class="active"' : ''; ?>><?= $i; ?></a>
                <?php endfor; ?>
            </div>
            */ ?>

            <!-- Paginacja -->

            <div class="pagination">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php
                        $totalPages = ceil(count($data) / $recordsPerPage);
                        for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item<?= ($i == $currentPage) ? ' active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>



        </div>
    </div>
</div>