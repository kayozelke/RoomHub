<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Room List</title>
</head>

<body>
<?php

use App\Libraries\DateOperator;
$dateOperator = new DateOperator();

// $dateOperator->getDividedTimeDates("2023-03-31", "2024-03-30");
$dateOperator->getDividedTimeDates("2023-03-31", "2024-03-30");

// $data = [
//     ['start' => '2023-01-01', 'end' => '2023-01-05'],
//     ['start' => '2023-01-06', 'end' => '2023-01-10'],
//     ['start' => '2023-01-11', 'end' => '2023-01-15'],
// ];

// $dateOperator->checkStartEndDateArrayContinuity($data);



?>
</body>

</html>