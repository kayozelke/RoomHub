<!doctype html>
<html lang="pl-PL" data-bs-theme="light" class="h-100">

<head>
    <script src="/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- icons for bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- boostrap 5 datatables css -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">

    <link href="/assets/css/style.css" rel="stylesheet">
    <title></title>
</head>

<body class="d-flex flex-column h-100" onload="startTime()">


    <!-- Dark mode button must have element-->
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>

    <!-- default dark mode button -->
    <!-- <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div> -->



    <?php
    $uri = service('uri'); //loading uri library which provides us some methods, where we can check segments of URL
    ?>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-primary bg-gradient" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="bd-mode-toggle navbar-brand btn bg-body-tertiary bg-opacity-25 bg-gradient" href="/"> RoomHub <i class="bi-ui-checks-grid"></i></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php /*if (session()->get('isLoggedIn')) :  ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(1)) == 'dashboard' ? 'active' : null ?>" href="/dashboard">Podsumowanie</a> <?php // segment first of our URL 
                                                                                                                                                    ?>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(1)) == 'users' ? 'active' : null ?>" href="/users">Użytkownicy</a> <?php // segment first of our URL 
                                                                                                                                        ?>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(1)) == 'buildings' ? 'active' : null ?>" href="/buildings">Budynki</a> <?php // segment first of our URL 
                                                                                                                                            ?>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(1)) == 'rooms' ? 'active' : null ?>" href="/rooms">Pokoje</a> <?php // segment first of our URL 
                                                                                                                                    ?>
                        </li>

                    <?php endif */
                    ?>


                </ul>
                <ul class="navbar-nav my-2 my-lg-0">
                    <?php if (!session()->get('isLoggedIn')) :  ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(1)) == '' ? 'active' : null ?>" href="/">Logowanie</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(1)) == 'register' ? 'active' : null ?>" href="/register">Rejestracja</a>
                        </li>
                    <?php endif
                    ?>


                    <?php if (session()->get('isLoggedIn')) :  ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- <i class="bi-person"></i> -->
                                <?= session()->get('firstname') . ' ' . session()->get('lastname') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/profile">Profil</a></li>
                                <li><a class="dropdown-item" href="/logout">Wyloguj</a></li>
                            </ul>
                        </li>
                    <?php endif
                    ?>

                    <!-- Dark mode switch -->
                    <li class="nav-item">
                        <div class="nav-link bd-mode-toggle">
                            <button class="btn dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                                <svg class="bi theme-icon-active" width="0.75em" height="0.75em">
                                    <use href="#circle-half"></use>
                                </svg>
                                <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                                        <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                                            <use href="#sun-fill"></use>
                                        </svg>
                                        Jasny
                                        <svg class="bi ms-auto d-none" width="1em" height="1em">
                                            <use href="#check2"></use>
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                                        <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                                            <use href="#moon-stars-fill"></use>
                                        </svg>
                                        Ciemny
                                        <svg class="bi ms-auto d-none" width="1em" height="1em">
                                            <use href="#check2"></use>
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                                        <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                                            <use href="#circle-half"></use>
                                        </svg>
                                        Automatycznie
                                        <svg class="bi ms-auto d-none" width="1em" height="1em">
                                            <use href="#check2"></use>
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
    </nav>


    <!-- icons for the sidebar -->
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="bootstrap" viewBox="0 0 118 94">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"></path>
        </symbol>
        <symbol id="home" viewBox="0 0 16 16">
            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"></path>
        </symbol>
        <symbol id="speedometer2" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"></path>
            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"></path>
        </symbol>
        <symbol id="table" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"></path>
        </symbol>
        <symbol id="people-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
        </symbol>
        <symbol id="grid" viewBox="0 0 16 16">
            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"></path>
        </symbol>
        <symbol id="house-fill" viewBox="0 0 16 16">
            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
        </symbol>
        <symbol id="people-fill" viewBox="0 0 16 16">
            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
        </symbol>
        <symbol id="buildings" viewBox="0 0 16 16">
            <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022ZM6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z" />
            <path d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z" />
        </symbol>
        <symbol id="columns" viewBox="0 0 16 16">
            <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm8.5 0v8H15V2zm0 9v3H15v-3zm-1-9H1v3h6.5zM1 14h6.5V6H1z" />
        </symbol>
        <symbol id="card-checklist" viewBox="0 0 16 16">
            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
        </symbol>
        <symbol id="search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
        </symbol>
        <symbol id="gear" viewBox="0 0 16 16">
            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
        </symbol>

    </svg>

    <main class="d-flex flex-nowrap <?= (!session()->get('isLoggedIn')) ? 'bg-img-room' : null ?>">

        <!-- sidebar -->
        <?php if (session()->get('isLoggedIn')) : ?>
            <!-- for larger devices -->
            <div class="d-flex flex-column flex-shrink-0 bg-body-tertiary sidebar d-none d-lg-block" style="width: 4.0rem;">
                <!-- <div class="sidebar"> -->
                <!-- <a href="/" class="d-block p-3 link-body-emphasis text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
                    <svg class="bi pe-none" width="40" height="32">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a> -->
                <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'dashboard' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Strona startowa">
                            <svg class="bi pe-none" width="24" height="24" role="img">
                                <!-- <use xlink:href="#house-fill" fill="white"></use> -->
                                <use xlink:href="#house-fill"></use>
                            </svg>
                            <!-- <img class="bi pe-none" role="img" src="/assets/icons/bootstrap.svg" alt="Bootstrap" width="24" height="24"> -->

                        </a>
                    </li>

                    <!-- Search -->
                    <!-- <li>
                        <a href="/search" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'search' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Wyszukiwanie">
                            <svg class="bi pe-none" width="24" height="24" role="img">
                                <use xlink:href="#search"></use>
                            </svg>
                        </a>
                    </li> -->
                    <!-- Objects -->
                    <li>
                        <a href="/buildings" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'buildings' || ($uri->getSegment(1)) == 'rooms' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Obiekty">
                            <svg class="bi pe-none" width="24" height="24" role="img">
                                <use xlink:href="#buildings"></use>
                            </svg>
                        </a>
                    </li>
                    <!-- Room Types -->
                    <li>
                        <a href="/roomtypes" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'roomtypes' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Rodzaje pokoi">
                            <svg class="bi pe-none" width="24" height="24" role="img">
                                <use xlink:href="#columns"></use>
                            </svg>
                        </a>
                    </li>
                    <!-- Reservations -->
                    <li>
                        <a href="/reservations" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'reservations' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Rezerwacje">
                            <svg class="bi pe-none" width="24" height="24" role="img">
                                <use xlink:href="#table"></use>
                            </svg>
                        </a>
                    </li>
                    <?php if (session()->get('isModerator')) : ?>
                        <!-- Users -->
                        <li>
                            <a href="/users" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'users' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Użytkownicy">
                                <svg class="bi pe-none" width="24" height="24" role="img">
                                    <use xlink:href="#people-fill"></use>
                                </svg>
                            </a>
                        </li>
                        <!-- System settings -->
                        <li>
                            <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Ustawienia">
                                <svg class="bi pe-none" width="24" height="24" role="img">
                                    <use xlink:href="#gear"></use>
                                </svg>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- for smaller devices -->
            <div class="d-flex flex-column flex-shrink-0 bg-body-tertiary sidebar d-lg-none" style="width: 2.9rem;">
                <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'dashboard' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Strona startowa">
                            <svg class="bi pe-none" width="14" height="14" role="img">
                                <use xlink:href="#house-fill"></use>
                            </svg>
                        </a>
                    </li>
                    <!-- Buildings -->
                    <li>
                        <a href="/buildings" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'buildings' || ($uri->getSegment(1)) == 'rooms' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Obiekty">
                            <svg class="bi pe-none" width="14" height="14" role="img">
                                <use xlink:href="#buildings"></use>
                            </svg>
                        </a>
                    </li>
                    <!-- Room Types -->
                    <li>
                        <a href="/roomtypes" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'roomtypes' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Rodzaje pokoi">
                            <svg class="bi pe-none" width="14" height="14" role="img">
                                <use xlink:href="#columns"></use>
                            </svg>
                        </a>
                    </li>
                    <!-- Reservations -->
                    <li>
                        <a href="/reservations" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'reservations' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Rezerwacje">
                            <svg class="bi pe-none" width="14" height="14" role="img">
                                <use xlink:href="#table"></use>
                            </svg>
                        </a>
                    </li>
                    <?php if (session()->get('isModerator')) : ?>
                        <!-- Users -->
                        <li>
                            <a href="/users" class="nav-link py-3 border-bottom rounded-0 <?= ($uri->getSegment(1)) == 'users' ? 'bg-secondary-subtle' : null ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Użytkownicy">
                                <svg class="bi pe-none" width="14" height="14" role="img">
                                    <use xlink:href="#people-fill"></use>
                                </svg>
                            </a>
                        </li>
                        <!-- System settings -->
                        <li>
                            <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Ustawienia">
                                <svg class="bi pe-none" width="14" height="14" role="img">
                                    <use xlink:href="#gear"></use>
                                </svg>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif ?>

        <div id="loader" class="bg-secondary-subtle"></div>

        <div class="container-xxl pt-2 mt-2" id="main-container">

            <?php if (session()->get('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                    <div>
                        <p class="d-flex my-0 py-0"><i class="bi bi-check-circle-fill mx-2"></i> <?= session()->get('success') ?></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->get('failure')) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
                    <div>
                        <p class="d-flex my-0 py-0"><i class="bi bi-exclamation-circle-fill mx-2"></i> <?= session()->get('failure') ?></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>