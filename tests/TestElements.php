<?php

class TestElements extends TestCase
{
    public function testHidden()
    {
        $this->form->open('test');
        $this->form->hidden('code')->value('123456');
        $this->form->close();

        $expected = '<input id="test-code" name="code" type="hidden" value="123456" />';
        $this->assertEquals($this->form->code->field(), $expected);
    }

    public function testHiddenDoesNotPopulate()
    {
        $this->setPostValue('code', 'hacked');

        $this->form->open('test');
        $this->form->hidden('code')->value('123456');
        $this->form->close();

        $expected = '<input id="test-code" name="code" type="hidden" value="123456" />';
        $this->assertEquals($this->form->code->field(), $expected);
    }
    
    public function testPasswordElement()
    {
        $this->form->open('test');
        $this->form->password('password');
        $this->form->close();

        $expected = '<input id="test-password" name="password" type="password" value="" />';
        $this->assertEquals($this->clean($this->form->password->field()), $expected);
    }

    public function testPasswordDoesNotPopulate()
    {
        $this->setPostValue('password', '123456');

        $this->form->open('test');
        $this->form->password('password');
        $this->form->close();

        $expected = '<input id="test-password" name="password" type="password" value="" />';
        $this->assertEquals($this->clean($this->form->password->field()), $expected);
    }

    public function testSelectElement()
    {
        $this->form->open('test');
        $this->form->select('gender')->options([
            'male' => 'Male',
            'female' => 'Female'
        ]);
        $this->form->close();

        $expected = '<select id="test-gender" name="gender"><option value="male">Male</option><option value="female">Female</option></select>';
        $this->assertEquals($this->clean($this->form->gender->field()), $expected);
    }

    public function testPopulatedSelectElement()
    {
        $this->setPostValue('gender', 'female');

        $this->form->open('test');
        $this->form->select('gender')->options([
            'male' => 'Male',
            'female' => 'Female'
        ]);
        $this->form->close();

        $expected = '<select id="test-gender" name="gender"><option value="male">Male</option><option value="female" selected>Female</option></select>';
        $this->assertEquals($this->clean($this->form->gender->field()), $expected);
    }

    public function testCheckBox()
    {
        $this->form->open('test');
        $this->form->checkbox('confirmed');
        $this->form->close();

        $expected = '<input id="test-confirmed" name="confirmed" value="1" />';
        $this->assertEquals($this->form->confirmed->field(), $expected);
    }

    public function testCheckBoxChecked()
    {
        $this->setPostValue('confirmed', 1);

        $this->form->open('test');
        $this->form->checkbox('confirmed');
        $this->form->close();

        $expected = '<input id="test-confirmed" name="confirmed" value="1" checked />';
        $this->assertEquals($this->form->confirmed->field(), $expected);
    }

    public function testCheckBoxCheckedByDefault()
    {
        $this->form->open('test');
        $this->form->checkbox('confirmed')->checked();
        $this->form->close();

        $expected = '<input id="test-confirmed" name="confirmed" value="1" checked />';
        $this->assertEquals($this->form->confirmed->field(), $expected);

        $this->setPostValue('_form', 'test');

        $expected = '<input id="test-confirmed" name="confirmed" value="1" />';
        $this->assertEquals($this->form->confirmed->field(), $expected);
    }

    public function testCheckBoxCustomValue()
    {
        $this->form->open('test');
        $this->form->checkbox('confirmed')->value('yes');
        $this->form->close();

        $expected = '<input id="test-confirmed" name="confirmed" value="yes" />';
        $this->assertEquals($this->form->confirmed->field(), $expected);
    }
}