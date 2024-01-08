<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">
            <?php if(isset($slot_data)) : ?>
                <h3>Edycja miejsca - ID <?=$slot_data['id']?></h3>
            <?php else : ?>
                <h3>Nowe miejsce - pokój <?=$room_data['number']?></h3>
            <?php endif ?>
            <hr>
            <form class="" method="post">
                <div class="row">
                    <div class="col-12 py-1">
                        <label for="number" class="form-label">Opis</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?=(isset($slot_data)) ? $slot_data['name'] : null?>" placeholder="np. Miejsce przy oknie, Miejsce przy wejściu, ..." required maxlength="255">
                    </div>
                </div>

                <div class="row py-1 mt-2">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary bg-gradient"><?=(isset($slot_data)) ? "Zapisz" : "Dodaj" ?></button>
                        <a href="/rooms/info/<?= $room_data['id'] ?>" class="btn btn-danger bg-gradient">Anuluj</a>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>