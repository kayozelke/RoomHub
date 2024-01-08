<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-secondary-subtle border from-wrapper shadow">
        <div class="container">
            <h3>Edycja pokoju</h3>
            <hr>
            <form class="" method="post">
                <div class="row">

                    
                    <div class="col-12 pt-1 pb-1">
                        <label for="building_id" class="form-label">Obiekt</label>
                        <select class="form-select" id="building_id" disabled>
                            <option value=""><?=$building_data['name']?></option>
                        </select>
                    </div>
                    
                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <label for="number" class="form-label">Numer pokoju</label>
                        <input type="text" class="form-control" name="number" id="number" value="<?=$room_data['number']?>" placeholder="np. 110, 713A, ..." required maxlength="10">
                    </div>

                    <div class="col-12 col-sm-6 pt-1 pb-1">
                        <label for="floor_eu" class="form-label">Piętro</label> 
                        <!-- min="-1" max="100" -->
                        <input type="number" class="form-control" id="floor_eu" name="floor_eu" value="<?=$room_data['floor_eu']?>" required>
                    </div>

                    <div class="col-12 pt-1 pb-1">
                        <label for="room_type_id" class="form-label">Typ pokoju</label>
                        <select class="form-select" name="room_type_id" id="room_type_id">
                            <!-- <option value="none">---</option> -->
                            <?php  foreach ($room_types as $row) : ?>
                                <option 
                                <?= ($room_data['room_type_id'] == $row['id']) ? 'selected=""' : null ?>
                                    value="<?=$row['id']?>">
                                        <?=$row['name']?> | <?=$row['price_month']?> PLN
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="container pt-3">
                        <?php if (isset($validation)) : ?>
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <?= $validation->listErrors() ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary bg-gradient">Zapisz</button>
                        <a href="/rooms/info/<?= $room_data['id'] ?>" class="btn btn-danger bg-gradient">Anuluj</a>
                    </div>
                    <!-- <div class="col-12 col-sm-8 text-right">
                            <a href="/">Already have an account</a>
                        </div> -->
                </div>
            </form>
        </div>
    </div>
</div>