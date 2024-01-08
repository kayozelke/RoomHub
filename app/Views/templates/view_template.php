<div class="d-flex justify-content-between align-items-center m-0 border-0 pt-4">
    <p class="h2 text">Test</p>
    <p class="d-flex justify-content-between align-items-center">

        <?php if (session()->get('isModerator')) : ?>
            <a type="button" class="btn btn-secondary m-1" href="#"><i class="bi-pencil-square"></i> Edytuj</a>
            <a type="button" class="btn btn-danger m-1" href="#"><i class="bi-trash"></i> Kasuj</a>
        <?php endif; ?>

    </p>
</div>
<hr>