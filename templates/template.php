<!-- DOCTYPE -->
<!DOCTYPE html>
<html lang="pl">
    <head>
        <?=$this->insert('headers')?>
    </head>

    <body>
        <?=$this->insert('navbar')?>

        <?=$this->section('content')?>

        <?=$this->insert('footer')?>

        <?=$this->insert('scripts')?>
    </body>
</html>


