<?php

class TestBasicForm extends TestCase
{
    public function testEmptyFormWithNoToken()
    {
        $expect = '<form method="GET" action="/"></form>';

        $this->form->open('test');
        $this->form->close()->noToken();

        $this->assertEquals($expect, $this->clean($this->form));
    }

    public function testEmptyFormWithToken()
    {
        $expect = '<form method="GET" action="/"><input type="hidden" name="_token" value="secret_token" /></form>';

        $this->form->open('test');
        $this->form->close();

        $this->assertEquals($expect, $this->clean($this->form));
    }

    public function testTextInputWithLabelsAndErrors()
    {
        $label = '<label for="test-name">Name:</label>';
        $field = '<input id="test-name" name="name" type="text" value="" />';
        $error = '<strong>Error message</strong>';

        $fullForm = $this->wrap('<div>' . $label . $field . $error . '</div>');

        $this->form->open('test');
        $this->form->text('name')->label('Name:');
        $this->form->close();

        $this->assertEquals($this->form->name->label(), $label);
        $this->assertEquals($this->form->name->field(), $field);
        $this->assertEquals($this->form->name->error(), $error);
        $this->assertEquals($fullForm, $this->clean($this->form));
    }
}