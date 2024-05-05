</div>
</main>

<!-- <div class="d-flex justify-content-between align-items-center m-0 border-0 p-0">
    <span class="text-body-secondary px-4 flex-fill text-start"> ... </span>
    <span class="text-body-secondary px-4 flex-fill text-center"> ... </span>
    <span class="text-body-secondary px-4 flex-fill text-end"> ... </span>
</div> -->





<!-- for larger devices -->
<footer class="footer mt-auto py-1 bg-body-secondary d-md d-none d-lg-block">
    <div class="row m-0 p-0">
        <div class="col d-flex justify-content-start">
            <div class="text-body-secondary px-4">
                <?php if (session()->get('isLoggedIn')) : ?>
                    <?php if (session()->get('isModerator')) : ?>
                        <i class="bi bi-person-fill-gear" style="font-size: 0.8rem;"></i>
                        Sesja moderatora
                    <?php else : ?>
                        <i class="bi bi-person-fill" style="font-size: 0.8rem;"></i>
                        Sesja użytkownika
                    <?php endif; ?>
                    <!-- <a id="session-timer"> </a> -->
                <?php endif; ?>
            </div>
        </div>
        <div class="col d-flex justify-content-center">
            <div class="text-body-secondary px-4">
                RoomHub 2024
                <?php if (session()->get('isModerator')) : ?>
                    | CI <?= CodeIgniter\CodeIgniter::CI_VERSION ?> | PHP <?= phpversion() ?>
                    <?php /*RoomHub 2024 | CI <?= CodeIgniter\CodeIgniter::CI_VERSION ?> | PHP <?= phpversion() ?> | <?= ucfirst(ENVIRONMENT) ?>*/ ?>
                <?php endif ?>
            </div>
        </div>
        <div class="col d-flex justify-content-end">
            <div class="text-body-secondary px-4">
                <?php if (session()->get('isLoggedIn')) : ?>
                    <i class="bi-clock" style="font-size: 0.8rem;"></i>
                    <a id="clock"></a>
                <?php endif ?>
            </div>
        </div>
    </div>


    <?php /*
        <div class="d-flex justify-content-between align-items-center m-0 border-0 p-0">

            <span class="text-body-secondary px-2 flex-grow-1 text-start">
                <?php if (session()->get('isLoggedIn')) : ?>
                    <i class="bi bi-person-fill" style="font-size: 0.8rem;"></i>
                    <?php if (session()->get('isModerator')) : ?>
                        <i class="bi bi-person-fill-gear" style="font-size: 0.8rem;"></i>
                        Sesja moderatora -
                    <?php else : ?>
                        Sesja użytkownika -
                    <?php endif; ?>
                    <a id="session-timer"> </a>
                <?php endif; ?>
            </span>

            <span class="text-body-secondary px-4 flex-grow-1 text-center">RoomHub 2024 | CI <?= CodeIgniter\CodeIgniter::CI_VERSION ?> | PHP <?= phpversion() ?> | <?= ucfirst(ENVIRONMENT) ?> </span>
            <span class="text-body-secondary px-2 flex-grow-1 text-end"><i class="bi-clock" style="font-size: 0.8rem;"></i> <a id="clock"></a></span>
            
        </div>
    */ ?>


</footer>
<!-- for smaller devices -->
<footer class="footer mt-auto py-1 bg-body-secondary d-md d-lg-none">
    <div class="d-flex justify-content-center align-items-center m-0 border-0 p-0">
        <span class="text-body-secondary px-4">RoomHub 2024</span>
    </div>
</footer>

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Sidebars tips when hover -->
<script src="/assets/js/sidebars.js"></script>
<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
<!-- Bootstrap 5 for datables -->
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


<!-- Datatables with polish language -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pl.json',
                "search": "Szukaj w tabeli"
            },
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 100],
        });
    });

    $(document).ready(function() {
        $('#dataTableSmall').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pl.json',
                "search": "Szukaj w tabeli"
            },
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50, 100],
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#loader").fadeOut(200);
    });
</script>

<script>
    function startTime() {
        const today = new Date();
        let y = today.getFullYear();
        let mo = today.getMonth() + 1;
        let d = today.getDate();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        mo = checkTime(mo);
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('clock').innerHTML = d + "." + mo + "." + y + " " + h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }
</script>

<?php /*if (session()->get('isLoggedIn')) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var expirationTimeInSeconds = <?php echo (session()->get('sessionEndTime') - time()); ?>;
            var timerElement = document.getElementById('session-timer');

            function updateSessionTimer() {
                if (expirationTimeInSeconds > 0) {
                    expirationTimeInSeconds--; //

                    var minutes = Math.floor(expirationTimeInSeconds / 60);
                    var seconds = expirationTimeInSeconds % 60;
                    minutes = checkTime(minutes);
                    seconds = checkTime(seconds);

                    timerElement.textContent = minutes + ':' + seconds + '';
                    setTimeout(updateSessionTimer, 1000);
                    if (expirationTimeInSeconds < 60) {
                        timerElement.classList.add("text-danger");
                    }
                } else {
                    timerElement.textContent = 'Sesja wygasła!';
                    timerElement.classList.add("fw-bold");
                    timerElement.classList.add("text-danger");
                }
            }

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i
                }; // add zero in front of numbers < 10
                return i;
            }

            updateSessionTimer();
        });
    </script>
<?php endif; */ ?>



</body>

</html>