<?php

class TestElements extends TestCase
{
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
}