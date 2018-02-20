<?php

session_start();
$_SESSION['errors'] = array(
    'name' => 'This field is required',
    'salary' => 'This field is required',
    'gender' => 'This field is required',
    'interests' => 'This field is required',
    'hobby' => 'This field is required',
    'cv' => 'This field is required',
    'terms' => 'This field is required',
    'message' => 'This field is required',
    'salary2' => 'This field is required',
    'password' => 'This field is required'
);

    require '_init_bootstrap.php';

    $form->open('test')
        ->method('POST');

    $form->text('name')
        ->label('Name:')
        ->placeholder('Enter your name...');

    $form->password('password')
        ->label('Password:')
        ->placeholder('Enter your password...')
        ->help('Minimum 6 characters.');

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

    $form->checklist('hobby')
        ->label('hobby:')
        ->options(['Basketball', 'Football', 'Tennis'])
        ->multiple();

    $form->checklist('interests')
        ->label('Interests:')
        ->options(['Basketball', 'Football', 'Tennis'])
        ->multiple()
        ->inline();

    $form->file('cv')
        ->label('CV:')
        ->multiple();

    $form->checkbox('terms')
        ->label('I agree with terms')
        ->checked();

    $form->textArea('message')
        ->label('Message');

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
                <h1>Vertical Form</h1>
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