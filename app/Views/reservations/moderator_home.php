<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h3 text">Rezerwacje - panel administracyjny</p>

    <!-- <a type="button" class="btn btn-success bg-gradient" href="/reservations/add"><i class="bi-plus-lg"></i> Nowa rezerwacja</a> -->

</div>
<hr class="py-0 my-2">

<!-- Cards -->
<div class="row py-5 row-cols-1 row-cols-lg-4 shadow m-3 rounded">
    <!-- by month -->
    <div class="col d-flex align-items-start">
        <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-5 flex-shrink-0 me-3 px-2 py-1">
            <i class="bi-calendar-check"></i>
        </div>
        <div class="d-flex flex-column h-100">
            <h3 class="fs-4 text-body-emphasis">Miesiąc</h3>
            <p class="pb-2">Wyświetla wszystkie rezerwacje, które trwają w wybranym miesiącu kalendarzowym.</p>
            <div class="flex-grow-1"></div>
            <div class="justify-content-center d-flex">
                <a href="/reservations/monthly" class="btn btn-primary bg-gradient"> Przeglądaj </a>
            </div>
        </div>
    </div>
    <!-- by user -->
    <div class="col d-flex align-items-start">
        <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-5 flex-shrink-0 me-3 px-2 py-1">
            <i class="bi-person"></i>
        </div>
        <div class="d-flex flex-column h-100">
            <h3 class="fs-4 text-body-emphasis">Mieszkaniec</h3>
            <p class="pb-2">Wyświetla wszystkie rezerwacje wybranego użytkownika. Umożliwia podgląd archiwalnych danych.</p>
            <div class="flex-grow-1"></div>
            <div class="justify-content-center d-flex">
                <a href="/reservations/by_user" class="btn btn-primary bg-gradient"> Przeglądaj </a>
            </div>
        </div>
    </div>
    <!-- filter -->
    <div class="col d-flex align-items-start">
        <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-5 flex-shrink-0 me-3 px-2 py-1">
            <i class="bi-search"></i>
        </div>
        <div class="d-flex flex-column h-100">
            <h3 class="fs-4 text-body-emphasis">Wyszukiwanie</h3>
            <p class="pb-2">Zaawansowane filtrowanie danych wg. obiektu, pokoju, miejsca, płatności. Umożliwia podgląd archiwalnych danych.</p>
            <div class="flex-grow-1"></div>
            <div class="justify-content-center d-flex">
                <a href="/reservations/filter_settings" class="btn btn-secondary bg-gradient"> Wyszukaj </a>
            </div>
        </div>
    </div>
    <!-- add -->
    <div class="col d-flex align-items-start">
        <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-5 flex-shrink-0 me-3 px-2 py-1">
            <i class="bi-plus-lg"></i>
        </div>
        <div class="d-flex flex-column h-100">
            <h3 class="fs-4 text-body-emphasis">Nowa rezerwacja</h3>
            <p class="pb-2">Przydzielanie użytkowników do miejsc w wybranym obiekcie.</p>
            <div class="flex-grow-1"></div>
            <div class="d-flex justify-content-center">
                <a href="/reservations/add" class="btn btn-success bg-gradient">Dodaj</a>
            </div>
        </div>

    </div>

</div>

<hr>


<!-- Notifications -->

<?php if ($active_and_ended_unpaid_reservations > 0) : ?>
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-lg-9 p-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>
                    <p class="d-flex my-0 py-0">
                        <i class="bi bi-exclamation-circle-fill  mx-2"></i>
                        Uwaga! Rozpoczęły się rezerwacje [<?= $active_and_ended_unpaid_reservations ?>], których
                        <a class="ms-1 text-danger" href="/reservations/by_filter?payment_done=0&end_date=<?= $today ?>">
                            opłaty nie zostały jeszcze uregulowane
                        </a>.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php /*if (session()->get('failure')) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div>
            <p class="d-flex my-0 py-0"><i class="bi bi-check-circle-fill mx-2"></i> <?= session()->get('failure') ?></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;*/ ?>

<!-- others -->
<div class="row mb-4 d-flex justify-content-center">
    <div class="col-12 col-lg-9 p-2 mb-4">
        <div class="overflow-x-auto border rounded">
            <table class="table table-sm table-transparent <?php //table-bordered
                                                            ?> m-0">
                <thead>
                    <tr>
                        <th scope="col" class="col-1 text-center align-middle">
                            Aktywne rezerwacje
                            <a class="icon-link icon-link-hover" href="/reservations/by_filter?status=1">
                                <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        </th>
                        <th scope="col" class="col-1 text-center align-middle">
                            Aktywne, opłacone rezerwacje
                            <a class="icon-link icon-link-hover" href="/reservations/by_filter?status=1&payment_done=1">
                                <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        </th>
                        <th scope="col" class="col-1 text-center align-middle">
                            Aktywne, nieopłacone rezerwacje
                            <a class="icon-link icon-link-hover" href="/reservations/by_filter?status=1&payment_done=0">
                                <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        </th>
                        <th scope="col" class="col-1 text-center align-middle">
                            Zakończone, nieopłacone rezerwacje
                            <a class="icon-link icon-link-hover" href="/reservations/by_filter?status=0&payment_done=0">
                                <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center align-middle"><?= $active_reservations_count ?></td>
                        <td class="text-center align-middle"><?= $active_paid_reservations_count ?></td>
                        <td class="text-center align-middle"><?= $active_unpaid_reservations_count ?></td>
                        <td class="text-center align-middle"><?= $ended_unpaid_reservations ?></td>
                    </tr>

                    <?php if ($active_reservations_count != 0) : ?>
                        <tr>
                            <td scope="row" class="fw-light text-center align-middle" colspan="3">
                                <div class="progress m-3" role="progressbar" style="height: 30px; min-width:350px">
                                    <?php
                                    if ($active_reservations_count == 0)
                                        $fill_percent = 0;
                                    else
                                        $fill_percent = intval(($active_paid_reservations_count / $active_reservations_count) * 100);

                                    $color_class = "bg-danger";

                                    if ($fill_percent >= 60)
                                        $color_class = "bg-warning";

                                    if ($fill_percent >= 95)
                                        $color_class = "bg-success";
                                    ?>
                                    <div class="progress-bar progress-bar-striped <?= $color_class ?>" style="width: <?= $fill_percent ?>%"></div>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <?= $fill_percent ?>% aktywnych rezerwacji zostało opłaconych
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>




    </div>
</div>