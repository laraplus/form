<?php

session_start();
$_SESSION['errors'] = array(
    'name' => 'This field is required',
    'salary' => 'This field is required',
    //'gender' => 'This field is required',
    'interests' => 'This field is required',
    //'hobby' => 'This field is required',
    'cv' => 'This field is required',
    //'terms' => 'This field is required',
    'message' => 'This field is required',
    //'salary2' => 'This field is required',
    'password' => 'This field is required'
);

require '_init_bulma.php';

$form->open('test')
    ->method('POST');

$form->text('name')
    ->label('Name:')
    ->placeholder('Enter your name...');

$form->text('salary')
    ->type('number')
    ->label('Salary:')
    ->placeholder('Enter your annual salary...')
    ->prefix('$')
    ->suffix('.00');

$form->select('gender')
    ->label('Gender:')
    ->options(['male' => 'Male', 'female' => 'Female'])
    ->placeholder('- Select gender -');

$form->checklist('interests')
    ->label('Interests:')
    ->options(['Basketball', 'Football', 'Tennis'])
    ->multiple();

$form->password('password')
    ->label('Password:')
    ->placeholder('Enter your password...')
    ->help('Minimum 6 characters.');

$form->checklist('hobby')
    ->label('hobby:')
    ->options(['Basketball', 'Football', 'Tennis'])
    ->inline();

$form->file('cv')
    ->label('CV:')
    ->multiple();

$form->checkbox('terms')
    ->label('I agree with terms')
    ->checked();

$form->textArea('message')
    ->label('Message');

$form->text('salary2')
    ->type('number')
    ->label('Salary2:')
    ->placeholder('Enter your annual salary...')
    ->prefix('$')
    ->suffix('.00');

$form->submit('submit')
    ->text('Submit!')
    ->addClass('is-link');

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
    <title>Laraplus form | Bulma Example</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="columns">
        <div class="column is-6 is light">
            <h2 class="title is-2">Horizontal Form</h2>
            <?= $form->style('horizontal') ?>
        </div>
        <div class="column is-6">
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

</body>
</html>