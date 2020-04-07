<?php

use Laraplus\Form\Form;

class TestFormGroups extends TestCase
{
    public function testFormGroup()
    {
        $this->form->open('test');
        $this->form->group('group', function(Form $form) {
            $form->text('email')->label('Email:');
            $form->password('password')->label('Password:');
        });
        $this->form->close();

        $emailLabel = '<label for="test-email">Email:</label>';
        $email = '<input id="test-email" name="email" type="text" value="" />';
        $passwordLabel = '<label for="test-password">Password:</label>';
        $password = '<input id="test-password" name="password" type="password" value="" />';

        $this->assertEquals($this->form->group->email->label(), $emailLabel);
        $this->assertEquals($this->form->group->email->field(), $email);
        $this->assertEquals($this->form->group->password->label(), $passwordLabel);
        $this->assertEquals($this->form->group->password->field(), $password);

        $group = '<div>' . $emailLabel . $email . '</div><div>' . $passwordLabel . $password . '</div>';
        $this->assertEquals($this->clean($this->form->group), $group);

        $form = $this->wrap($group);
        $this->assertEquals($this->clean($this->form), $form);
    }

    public function testPostedFormGroup()
    {
        $this->setPostValue('email', 'john.doe@gmail.com');

        $this->form->open('test');
        $this->form->group('group', function(Form $form) {
            $form->text('email')->label('Email:');
        });
        $this->form->close();

        $email = '<input id="test-email" name="email" type="text" value="john.doe@gmail.com" />';
        $this->assertEquals($this->form->group->email->field(), $email);
    }

    public function testModelFormGroup()
    {
        $this->form->open('test')->model(['email' => 'john.doe@gmail.com']);
        $this->form->group('group', function(Form $form) {
            $form->text('email')->label('Email:');
        });
        $this->form->close();

        $email = '<input id="test-email" name="email" type="text" value="john.doe@gmail.com" />';
        $this->assertEquals($this->form->group->email->field(), $email);
    }
}