<?php

class TestForm extends TestCase
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

        $this->setToken('secret_token');

        $this->form->open('test');
        $this->form->close();

        $this->assertEquals($expect, $this->clean($this->form));
    }

    public function testElementWithLabelsAndErrors()
    {
        $label = '<label for="test-name">Name:</label>';
        $field = '<input id="test-name" name="name" type="text" value="" />';
        $error = '<strong>Error message</strong>';
        $fullForm = $this->wrap('<div>' . $label . $field . $error . '</div>');

        $this->setError('name', 'Error message');

        $this->form->open('test');
        $this->form->text('name')->label('Name:');
        $this->form->close();

        $this->assertEquals($this->form->name->label(), $label);
        $this->assertEquals($this->form->name->field(), $field);
        $this->assertEquals($this->form->name->error(), $error);
        $this->assertEquals($fullForm, $this->clean($this->form));
    }

    public function testPopulateWithModel()
    {
        $model = ['name' => 'John Doe'];

        $this->form->open('test')->model($model);
        $this->form->text('name')->label('Name:');
        $this->form->close();

        $field = '<input id="test-name" name="name" type="text" value="John Doe" />';
        $this->assertEquals($this->form->name->field(), $field);
    }

    public function testElementWithPostValue()
    {
        $this->setPostValue('name', 'John Doe');

        $this->form->open('test');
        $this->form->text('name')->label('Name:');
        $this->form->close();

        $field = '<input id="test-name" name="name" type="text" value="John Doe" />';
        $this->assertEquals($this->form->name->field(), $field);
    }

    public function testElementWithOldValue()
    {
        $this->setOldValue('name', 'John Doe');

        $this->form->open('test');
        $this->form->text('name')->label('Name:');
        $this->form->close();

        $field = '<input id="test-name" name="name" type="text" value="John Doe" />';
        $this->assertEquals($this->form->name->field(), $field);
    }

    public function testPopulatePriority()
    {
        $model = ['name' => 'Jane Doe'];

        $this->form->open('test')->model($model);
        $this->form->text('name')->label('Name:')->value('John Smith');
        $this->form->close();

        $field = '<input id="test-name" name="name" type="text" value="John Smith" />';
        $this->assertEquals($this->form->name->field(), $field);

        $this->setOldValue('name', 'John Doe');

        $field = '<input id="test-name" name="name" type="text" value="John Doe" />';
        $this->assertEquals($this->form->name->field(), $field);

        $this->setPostValue('name', 'Jane Smith');

        $field = '<input id="test-name" name="name" type="text" value="Jane Smith" />';
        $this->assertEquals($this->form->name->field(), $field);
    }
}