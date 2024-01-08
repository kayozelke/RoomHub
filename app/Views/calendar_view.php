
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4"><?php echo $monthYear; ?></h2>
            <nav class="mb-3">
                <a class="btn btn-primary" href="<?php echo $prevMonthLink; ?>">Previous Month</a>
                <a class="btn btn-primary" href="<?php echo $nextMonthLink; ?>">Next Month</a>
            </nav>
            <?php echo $calendarHTML; ?>
        </div>
    </div>
</div>




<!-- <table class="table table-hover">
<thead>
<tr>
    <th scope="col" class="col-1">#</th>
    <th scope="col" class="col-1">1</th>
    <th scope="col" class="col-1">12.5</th>
    <th scope="col" class="col-1">301</th>
    <th scope="col" class="col-1">405.88</th>
    <th scope="col" class="col-1">77</th>
</tr>
</thead>
<tbody id="table-body">
<tr>
    <th scope="row">123456</th>
    <td class="table-danger"></td>
    <td class="table-success"></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
</tbody> -->