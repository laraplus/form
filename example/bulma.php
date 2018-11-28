<?php

require '_init_bulma.php';
require '_init_forms.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laraplus form | Bulma Example</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css" rel="stylesheet">
</head>
<body>

<div class="section">
    <div class="container">
        <div class="columns is-desktop">
            <div class="column">
                <h2 class="title is-2">Horizontal Form</h2>
                <?= $form->style('horizontal') ?>
            </div>
            <div class="column">
                <h2 class="title is-2">Vertical Form</h2>
                <?= $form2->style('vertical') ?>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <h2 class="title is-2">Inline Form</h2>
                <?= $form3->style('inline') ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>