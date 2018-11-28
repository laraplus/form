<?php

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