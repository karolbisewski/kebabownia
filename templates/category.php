<?php $this->layout('temp_fancy', ['title' => 'Kup już teraz!']) ?>

<div class="container space-top">
    <div class="bs-example">
	      <!-- Bootstrap Grid -->
        <?php foreach ($products as $product) { ?>
	          <div class="row">
	              <div class="col-sm-4">
                    <div class="crop">
                        <a href="/obrazki_potraw/<?=$product['img']?>" rel="lightbox">
                            <img src="/obrazki_potraw/<?=$product['img']?>" class="img-fluid" alt="obrazek <?=$product['nazwa']?>">
                        </a>
                    </div>
                </div>
	              <div class="col-sm-8">
                    <p class="h1"><?=$product['nazwa']?></p>
                    <p class="lead">
                        <?=$product['opis']?>
                    </p>
                </div>
	          </div>
        <?php
        }
        ?>
    </div>
</div>

