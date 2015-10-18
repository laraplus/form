<?php

    require '_init.php';

    $form->open('test')
        ->method('POST');

    $form->text('name')
        ->label('Name:')
        ->placeholder('Enter your name...');

    $form->password('password')
        ->label('Password:')
        ->placeholder('Enter your password...')
        ->help('Minimum 6 characters.');

    $form->select('gender')
        ->label('Gender:')
        ->options(['male' => 'Male', 'female' => 'Female'])
        ->placeholder('- Select gender -');

    $form->submit('submit')
        ->text('Submit!')
        ->addClass('btn-primary');

    $form->close();

    $form2 = clone $form;
    $form3 = clone $form;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laraplus form | Bootstrap Example</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Horizontal Form</h1>
                <div class="well">
                    <?= $form->style('horizontal') ?>
                </div>
            </div>
            <div class="col-md-6">
                <h1>Horizontal Form</h1>
                <div class="well">
                    <?= $form2->style('vertical') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1>Inline Form</h1>
                <div class="well">
                    <?= $form3->style('inline') ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>