<?php $this->layout('temp_fancy', ['title' => 'Kontakt']) ?>

<div class="container">
    <h2 class="text-center">Kontakt</h2>
    <div class="row">
        <div class="col-sm-5">
            <p>Daj nam znać co o nas sądzisz, a opowiemy w ciągu 24h!</p>
            <p><span class="glyphicon glyphicon-map-marker"></span> Gdańsk, Polska</p>
            <p><span class="glyphicon glyphicon-phone"></span> +00 1515151515</p>
            <p><span class="glyphicon glyphicon-envelope"></span> myemail@something.com</p>
        </div>
        <div class="col-sm-7 slideanim">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <input class="form-control" id="name" name="name" placeholder="Imię" type="text" required>
                </div>
                <div class="col-sm-6 form-group">
                    <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
                </div>
            </div>
            <textarea class="form-control" id="comments" name="comments" placeholder="Treść komentarza" rows="5"></textarea><br>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <button class="btn btn-default pull-right" type="submit">Wyślij</button>
                </div>
            </div>
        </div>
    </div>
</div>
