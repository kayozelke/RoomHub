<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h1 text">Dzień dobry, <?= session()->get('firstname') ?>!</p>
</div>
<hr>



<div class="d-flex justify-content-start">
    <h5 class="p-2 d-flex"><i class="bi bi-database-fill-gear me-2"></i> Witaj w&nbsp;trybie moderatora. </h5>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 align-items-stretch g-4 py-4">
    <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow bg-img-floor hover-zoom">
            <a href="/buildings" class="text-decoration-none d-flex flex-column h-100">
                <div class="d-flex flex-column flex-grow-1 h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="py-5 mt-4 mb-4 fs-3 lh-sm fw-bold text-center">Zarządzanie obiektami i&nbsp;miejscami</h3>
                    <ul class="d-flex list-unstyled mt-auto">
                        <li class="me-auto">
                            <i class="bi bi-arrow-up-right-square-fill h4"></i>
                        </li>
                    </ul>
                </div>
            </a>
        </div>
    </div>

    <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow bg-img-room hover-zoom">
            <a href="/roomtypes" class="text-decoration-none d-flex flex-column h-100">
                <div class="d-flex flex-column flex-grow-1 h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="py-5 mt-4 mb-4 fs-3 lh-sm fw-bold text-center">Rodzaje pokojów i&nbsp;cennik opłat</h3>
                    <ul class="d-flex list-unstyled mt-auto">
                        <li class="me-auto">
                            <i class="bi bi-arrow-up-right-square-fill h4"></i>
                        </li>
                    </ul>
                </div>
            </a>
        </div>
    </div>

    <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow bg-img-books hover-zoom">
            <a href="/reservations" class="text-decoration-none d-flex flex-column h-100">
                <div class="d-flex flex-column flex-grow-1 h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="py-5 mt-5 mb-4 fs-3 lh-sm fw-bold text-center">Zarządzanie rezerwacjami</h3>
                    <ul class="d-flex list-unstyled mt-auto">
                        <li class="me-auto">
                            <i class="bi bi-arrow-up-right-square-fill h4"></i>
                        </li>
                    </ul>
                </div>
            </a>
        </div>
    </div>

    <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow bg-img-people hover-zoom">
            <a href="/users" class="text-decoration-none d-flex flex-column h-100">
                <div class="d-flex flex-column flex-grow-1 h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="py-5 mt-5 mb-4 fs-3 lh-sm fw-bold text-center">Zarządzanie użytkownikami</h3>
                    <ul class="d-flex list-unstyled mt-auto">
                        <li class="me-auto">
                            <i class="bi bi-arrow-up-right-square-fill h4"></i>
                        </li>
                    </ul>
                </div>
            </a>
        </div>
    </div>




</div>

<hr>

<div class="d-flex justify-content-center">
    <h5 class="p-2 d-flex">Statystyki <i class="bi bi-clipboard-data ms-2"></i></h5> 
</div>

<div class="row pb-4 d-flex justify-content-center">
    <div class="col-12 col-lg-9 p-2 mb-4 shadow">
        <div class="overflow-x-auto border rounded">
            <table class="table table-sm table-transparent <?php //table-bordered
                                                            ?> m-0">
                <thead>
                    <tr>
                        <th scope="col" class="col-1 text-center align-middle">Liczba obiektów</th>
                        <th scope="col" class="col-1 text-center align-middle">Wszystkie pokoje</th>
                        <th scope="col" class="col-1 text-center align-middle">Wszystkie miejsca</th>
                        <th scope="col" class="col-1 text-center align-middle">Liczba mieszkańców</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center align-middle"><?= $buildings_count ?></td>
                        <td class="text-center align-middle"><?= $rooms_count_total ?></td>
                        <td class="text-center align-middle"><?= $slots_count_total ?></td>
                        <td class="text-center align-middle"><?= $today_residents_count ?></td>
                    </tr>

                    <tr>
                        <td scope="row" class="fw-light text-center align-middle" colspan="3">
                            <div class="progress m-3" role="progressbar" style="height: 30px; min-width:350px">
                                <?php
                                if ($slots_count_total == 0)
                                    $fill_percent = 0;
                                else
                                    $fill_percent = intval(($today_residents_count / $slots_count_total) * 100);

                                $color_class = "bg-primary";

                                // if ($fill_percent >= 60)
                                //     $color_class = "bg-warning";

                                // if ($fill_percent >= 95)
                                //     $color_class = "bg-success";
                                ?>
                                <div class="progress-bar progress-bar-striped <?= $color_class ?>" style="width: <?= $fill_percent ?>%"></div>
                            </div>
                        </td>
                        <td class="text-center align-middle"><?= $fill_percent ?>% zajętych miejsc we wszystkich <a href="/buildings/">obiektach</a></td>
                    </tr>


                    <tr>
                        <td scope="row" class="fw-light text-center align-middle" colspan="3">
                            <div class="progress m-3" role="progressbar" style="height: 30px; min-width:350px">
                                <?php
                                if ($today_residents_count == 0)
                                    $fill_percent = 0;
                                else
                                    $fill_percent = intval(($paid_reservations_active / $today_residents_count) * 100);

                                $color_class = "bg-danger";

                                if ($fill_percent >= 60)
                                    $color_class = "bg-warning";

                                if ($fill_percent >= 95)
                                    $color_class = "bg-success";
                                ?>
                                <div class="progress-bar progress-bar-striped <?= $color_class ?>" style="width: <?= $fill_percent ?>%"></div>
                            </div>
                        </td>
                        <td class="text-center align-middle"><?= $fill_percent ?>% <a href="/reservations/by_filter?status=1">aktywnych rezerwacji</a> zostało opłaconych</td>
                    </tr>
                </tbody>
            </table>
        </div>




    </div>
</div>






<script>
    // Zoom when hover object 'zoomable' objects
    var zoomableElements = document.getElementsByClassName('zoomable');

    Array.from(zoomableElements).forEach(function(element) {
        element.addEventListener('mouseover', function() {
            this.classList.add('zoom-effect');
        });

        element.addEventListener('mouseout', function() {
            this.classList.remove('zoom-effect');
        });
    });
</script>