<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h1 text">Dzień dobry, <?= session()->get('firstname') ?>!</p>
</div>
<hr>
<!-- 
<div class="row mx-0 px-0">
    <div class="col-12 col-md-6 my-0 py-2 py-3">
        <div class="row px-3 py-1">
            <div class="col-12 card py-3">
                <a href="#" class="text-decoration-none text-white">
                    <div class="bg-image d-flex justify-content-center align-items-center building-card-title">
                        <div class="row p-1">
                            <div class="col">
                                <h3 class="text-center">#></h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center my-0 mx-1 p-1">
            <a type="button" class="btn btn-secondary bg-gradient my-0 mx-1" href="#"><i class="bi-info-square"></i> Informacje</a>
            <a type="button" class="btn btn-primary bg-gradient my-0 ms-1" href="#"><i class="bi-door-closed"></i> Pokoje</a>
        </div>
    </div>
</div>
<hr> -->


<?php if ($unpaid_reservations_count > 0) : ?>
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-lg-9 p-2">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div>
                    <p class="d-flex my-0 py-0">
                        <i class="bi bi-exclamation-circle-fill  mx-2"></i>
                        Prosimy o uregulowanie opłat za najem pokoju.
                        <a class="ms-1 text-warning" href="/reservations">Sprawdź szczegóły
                        </a>.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-center">
    <h4 class="p-2 d-flex">Gdzie się dziś wybierasz? <i class="bi bi-signpost-2-fill mx-2"></i></h4>
</div>
<div class="row row-cols-1 row-cols-xl-3 align-items-stretch g-4 py-4">
    <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow bg-img-floor hover-zoom">
            <a href="/buildings/" class="text-decoration-none d-flex flex-column h-100">
                <div class="d-flex flex-column flex-grow-1 h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="py-5 mt-4 mb-4 display-6 lh-sm fw-bold text-center">Podgląd miejsc w&nbsp;domach studenckich</h3>
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
            <a href="/roomtypes/" class="text-decoration-none d-flex flex-column h-100">
                <div class="d-flex flex-column flex-grow-1 h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="py-5 mt-4 mb-4 display-6 lh-sm fw-bold text-center">Rodzaje pokojów i&nbsp;cennik opłat</h3>
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
            <a href="/reservations/" class="text-decoration-none d-flex flex-column h-100">
                <div class="d-flex flex-column flex-grow-1 h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="py-5 mt-5 mb-4 display-6 lh-sm fw-bold text-center">Przegląd Twoich rezerwacji</h3>
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



<script>
    // Pobierz wszystkie elementy z klasą 'zoomable'
    var zoomableElements = document.getElementsByClassName('zoomable');

    // Dodaj nasłuchiwanie dla każdego elementu
    Array.from(zoomableElements).forEach(function(element) {
        element.addEventListener('mouseover', function() {
            this.classList.add('zoom-effect');
        });

        element.addEventListener('mouseout', function() {
            this.classList.remove('zoom-effect');
        });
    });
</script>