<div class="container">
        <div class="col-12 pt-1">

            <?php

            // Dane

            // Ilość kopii
            $ilosc_kopii = 1;

            // Powielanie danych
            for ($i = 0; $i < $ilosc_kopii; $i++) {
                foreach ($data as $row) {
                    $dane_powielone[] = $row;
                }
            }
            $data=$dane_powielone;

            // Liczba rekordów na stronie
            $recordsPerPage = 15;

            // Numer aktualnej strony
            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

            // Oblicz indeks początkowy dla aktualnej strony
            $startIndex = ($currentPage - 1) * $recordsPerPage;

            // Pobierz tylko rekordy dla aktualnej strony
            $currentPageData = array_slice($data, $startIndex, $recordsPerPage);

            ?>

            <div class="table-responsive small">
                <div class="overflow-auto">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Imię</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">Poziom</th>
                                <th scope="col">Utworzono</th>
                                <th scope="col">Zmodyfikowano</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($currentPageData as $row) : ?>
                                <tr>
                                    <th scope="row"><?= $row['id']; ?></th>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['firstname']; ?></td>
                                    <td><?= $row['lastname']; ?></td>
                                    <td><?= $row['privileges_level']; ?></td>
                                    <td><?= $row['created_at']; ?></td>
                                    <td><?= $row['updated_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

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

            <hr>
            <!-- Paginacja -->
            <div class="pagination table-responsive">
                <div class="overflow-auto">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
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