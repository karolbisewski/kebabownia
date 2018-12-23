

<nav class="navbar navbar-expand-lg ">
    <!-- Navbar content -->
    <div class=" container collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a class="nav-link" href="/">Strona główna </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Rodzaje potraw
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/katalog/wszystko">Wszystkie potrawy</a>
                    <div class="dropdown-divider"></div>
                    <?php
                    foreach ($menu as $kat):
                    ?>
                        <a class="dropdown-item" href="/katalog/<?=$kat['nazwa']?>"><?=$kat['nazwa']?></a>
                    <?php endforeach ?>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/kontakt">Kontakt</a>
            </li>
        </ul>
        <ul class="navbar-nav justify-content-end">
            <?php if ($logged) { ?>
                <li class="nav-item">
                    <a class="nav-link disabled">Witaj <?=$login?>!</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Panel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Wyloguj się</a>
                </li>

            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link disabled" href="/login">Panel</a>
                </li>
            <?php } ?>
    </div>
</nav>
