<?php
session_start();

require 'vendor/autoload.php';

function sendQuery($conn, $sql) {

    $wynik = mysqli_query($conn, $sql);

    $results = [];
    while (($wiersz = @mysqli_fetch_array($wynik))) {
        $results[] = $wiersz;
    }
    return $results;
}


function goToMainMenu(){
    header("Location: /");
    //echo 'DIE';
    die();
}

// Create new Plates instance
$templates = new League\Plates\Engine('templates/');

// Render a template


$polaczenie = @mysqli_connect('localhost', 'bisewski', '123', 'pai_bisewski');
//Dynamiczne menu (dane z bazy)

if (!$polaczenie) {
    die('Wystąpił błąd połączenia: ' . mysqli_connect_errno());
}
@mysqli_query($polaczenie, 'SET NAMES utf8');


$page_to_load = '';

if (isset($_GET['site'])) {
    $page_to_load = $_GET['site'];
    /* if (in_array($_GET['site'], ['order', 'main', 'contact', 'login', 'logout', 'edit', '404'])) {
     *     $page_to_load = $_GET['site'];
     * } */
}
//echo "<br>http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]<br>";
$category = 'wszystko';
if (isset($_GET['kategoria']) && $_GET['kategoria'] !== 'wszystko') {
    $category = mysqli_real_escape_string($polaczenie ,$_GET['kategoria']);
    $sql = "SELECT nazwa
            FROM kategorie
            WHERE nazwa = '{$category}'
            LIMIT 1";
    $result = mysqli_query($polaczenie, $sql);
    $how_many = mysqli_num_rows($result);
    if ($how_many != 1) {
        $_SESSION['logged'] = true;
    }
}
//$page_to_load = 'login';

/* echo $page_to_load;
 * echo $category; */


$sql = "SELECT nazwa FROM kategorie";
$menu = sendQuery($polaczenie, $sql);
$templates->addData(['menu' => $menu]);


if (isset($_SESSION['logged'])) {
    $templates->addData(['logged' => true, 'login' => $_SESSION['login']]);
}
else {
    $templates->addData(['logged' => false]);}

// sprawdz czy użytownik jest zalogowany i z uprawnieniami
$admin = false;
if (isset($_SESSION['logged']) && $_SESSION['logged']) {
    $admin = true;
}
switch($page_to_load) {

    case 'order':
        if ($category == 'wszystko' || $category == "") {
            $sql = 'SELECT `id`, `nazwa`, `opis`, `img`
               FROM `produkty`
               ORDER BY `nazwa`';
        } else {
            $sql = "SELECT p.id, p.nazwa, p.opis, p.img, k.nazwa AS kategoria
               FROM produkty AS p, kategorie AS k
               WHERE p.kategoria_id = k.id AND k.nazwa ='{$category}'
            ";
        }

        $results = sendQuery($polaczenie, $sql);

        if (sizeof($results) > 0) {
            echo $templates->render('category', ['products' => $results]);
        } else {
            echo $templates->render('category-404', []);
        }
        break;

    case 'contact':
        //Logic to add or HTML for add
        echo $templates->render('contact', []);
        break;
    case 'login':
        $failed = false;
        if(isset($_POST['login'])) {
            $failed = true;
            //tryined to login
            if (isset($_POST['password'])) {

                $h_login = mysqli_real_escape_string($polaczenie, $_POST['login']);
                $password = $_POST['password'];
                $h_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "SELECT login, haslo
                       FROM uzytkownicy
                       WHERE login = '{$h_login}'";
                $ans = sendQuery($polaczenie, $sql);
                if (sizeof($ans) == 1) {
                    if(password_verify($password, $ans[0]['haslo'])) {
                        // zalogowany
                        $_SESSION['logged'] = true;
                        $_SESSION['login'] = $h_login;
                        $admin = true;
                    }
                }
            }
        }

        if($admin){
            /* Jest to administrator.
               Wyjęcie wszystkiego z bazy danych */
            $templates->addData(['logged' => true, 'login' => $_SESSION['login']]);
            $cat = sendQuery($polaczenie,"SELECT * FROM kategorie");
            $prod = sendQuery($polaczenie, "SELECT * FROM produkty");
            $col_c = sendQuery($polaczenie, "SHOW COLUMNS FROM kategorie");
            $col_p = sendQuery($polaczenie, "SHOW COLUMNS FROM produkty");
            echo $templates->render('admin_panel', ["products" => $prod, "categories" => $cat]);
        } else {
            /* Logowanie się niepowiodło */
            echo $templates->render('login', ['failed' => $failed]);
        }
        break;

    case 'edit':
        /* Podstrona do której wysyłane są dane, które trzeba zmienić w bazie danych.
           Zapytanie powinno zawierać:
           {
           "action": (add|delete) // dodawanie, usuwanie?
           "table": (kategorie|produkty) // której tabeli ma dotyczyć akcja?
           // oraz dane które mają się znaleźć w tabeli.
           "id": [...]
           "nazwa": [...]
           [...]
           }
         */
        // print_r($_POST);
        if (!$admin) {
            // nie jest to zalogowany użytkownik
            echo 'not logged';
            goToMainMenu();
        }
        $table = $_POST['table'];
        unset($_POST['table']);
        if (!isset($table) || !in_array($table, ['kategorie', 'produkty'])) {
            // próba edycji dziwnych tabel
            echo 'unknown table';
            goToMainMenu();
        }

        $action = $_POST['action'];
        unset($_POST['action']);
        if (!isset($action) || !in_array($action, ['edit', 'add', 'delete'])) {
            // próba pojecia niedozwolonej akcji
            echo 'unknown action';
            goToMainMenu();
        }
        $data = $_POST;

        // sanityzacja
        foreach ($data as $atr => $val) {
            // mysqli chroni przed sql injection, a htmlentities przed XSS.
            $data[$atr] = mysqli_real_escape_string($polaczenie, htmlentities($val));
        }
        if ($action == 'delete') {
            $id = intval($data['id']);
            $sql = "DELETE FROM {$table} WHERE id = {$id}";
        }
        if ($action == 'add') {
            if ($table == 'kategorie') {
                $nazwa = $data['nazwa'];
                $sql = "INSERT INTO kategorie
                       VALUES (NULL, '{$nazwa}')";
            }
            if ($table == 'produkty') {
                $kat_id = $data["kategoria_id"];
                $nazwa = $data['nazwa'];
                $opis = $data['opis'];
                $img = $data['img'];
                $sql = "INSERT INTO produkty
                       VALUES (NULL, {$kat_id}, '{$nazwa}', '{$opis}', '{$img}')";
            }
        }
        if ($action == 'edit') {
            if ($table == 'kategorie') {
                $id = intval($data['id']);
                $nazwa = $data['nazwa'];
                $sql = "UPDATE kategorie
                   SET nazwa = '{$nazwa}'
                   WHERE id = {$id}";
            }
            if ($table == 'produkty') {
                $id = intval($data['id']);
                $nazwa = $data['nazwa'];
                $kate = intval($data['kategoria_id']);
                $opis = $data['opis'];
                $img = $data['img'];

                $sql = "UPDATE produkty
                    SET nazwa = '{$nazwa}',
                        kategoria_id = {$kate},
                        opis = '{$opis}',
                        img = '{$img}'
                    WHERE id = {$id}";
            }
        }
        sendQuery($polaczenie, $sql);
        break;


    case 'logout':
        // usuwa PHPSESSID z przeglądarki
        if ( isset( $_COOKIE[session_name()] ) ) {
            setcookie( session_name(), "", time()-3600, "/" );
        }
        // usuniecie sesji z zmiennej
        $_SESSION = array();
        // usuniecie sesji z dysku
        session_destroy();

        $templates->addData(['logged' => false]);
        // nie ma break!
    case '':
        /* strona główna */
        echo $templates->render('main', []);
        break;

    default:
        /* zwykłe 404 */
        echo $templates->render('404', []);
        break;

}

mysqli_close($polaczenie);
