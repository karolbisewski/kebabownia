<?php $this->layout('temp_fast', ['title' => 'Panel administratora']) ?>

<div class="container space-top">
    <div id="output">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kategoria</th>
                    <th scope="col">Akcja</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $n) { ?>
                    <tr state="normal" table='kategorie'>
                        <td name="id" scope="col">
                            <?=$n['id']?>
                        </td>
                        <td name="nazwa">
                            <?=$n['nazwa']?>
                        </td>
                        <th>
                            <button type="button" class="btn btn-light edit-bt">💾</button>
                            <button type="button" class="btn btn-light delete-bt">❌</button>
                        </th>
                    </tr>
                <?php } ?>
                <tr>
                    <form id="form_cat" method="POST" action="/index.php?site=edit">
                        <input type="hidden" name="table" value="kategorie">
                        <input type="hidden" name="action" value="add">
                        <th scope="col">#</th>
                        <th scope="col"><input type="text" class="form-control" placeholder="Nazwa" name="nazwa"></th>
                        <th scope="col"><button type="button" onclick="sendForm('form_cat');" class="btn btn-primary mb-2">Dodaj</button></th>
                    </form>
                </tr>
            </tbody>
        </table>


        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kategoria</th>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Zdjecie</th>
                    <th scope="col">- Akcja -</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $n) { ?>
                    <tr state="normal" table='produkty'>
                        <td name="id" scope="col"><?=$n['id']?></td>
                        <td name="kategoria_id"><?=$n['kategoria_id']?></td>
                        <td name="nazwa"><?=$n['nazwa']?></td>
                        <td name="opis"><?=$n['opis']?></td>
                        <td name="img"><?=$n['img']?></td>
                        <th><button type="button" class="btn btn-light edit-bt">💾</button>
                            <button type="button" class="btn btn-light delete-bt">❌</button></th>
                    </tr>
                <?php } ?>
                <tr>
                    <form id="form_prod" method="POST" action="/index.php?site=edit">
                        <input type="hidden" name="table" value="produkty">
                        <input type="hidden" name="action" value="add">
                        <th scope="col">#</th>
                        <th scope="col"><input name="kategoria_id" type="text" class="form-control" placeholder="Kategoria"></th>
                        <th scope="col"><input name="nazwa"type="text" class="form-control" placeholder="Nazwa"></th>
                        <th scope="col"><input name="opis" type="text" class="form-control" placeholder="Opis"></th>
                        <th scope="col"><input name="img" type="text" class="form-control" placeholder="sciezka.png" ></th>
                        <th scope="col"><button  type="button" onclick="sendForm('form_prod');"  class="btn btn-primary mb-2">Dodaj</button></th>
                    </form>
                </tr>
            </tbody>
        </table>
    </div>
</div>
