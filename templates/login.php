<?php $this->layout('temp_fancy', ['title' => 'Zaloguj się']) ?>

<div class="container space-top">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <form action="/login" method="POST">
                <div class="form-group">
                    <label for="login">Nazwa użytkownika</label>
                    <input type="text" class="form-control" name="login" aria-describedby="emailHelp" placeholder="Podaj nazwę użytkownika">
                </div>
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" class="form-control" name="password" placeholder="Hasło">
                </div>
                <button type="submit" class="btn btn-primary">Zaloguj się</button>
            </form></div>
        <div class="col-sm-4"></div>
    </div>
</div>
