<?php

class TestElements extends TestCase
{
    public function testHiddenElement()
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

    public function testSelectElementWithOptionAttributes()
    {
        $this->form->open('test');
        $this->form->select('gender')->options([
            'male' => 'Male',
            'female' => 'Female'
        ])->optionAttrs([
            'male' => ['data-id' => 0],
            'female' => ['data-id'=> 1]
        ]);
        $this->form->close();

        $expected = '<select id="test-gender" name="gender"><option data-id="0" value="male">Male</option><option data-id="1" value="female">Female</option></select>';
        $this->assertEquals($this->clean($this->form->gender->field()), $expected);
    }

    public function testMultiSelectElement()
    {
        $this->form->open('test');
        $this->form->select('sports')->options(['Basketball', 'Football', 'Tennis'])->multiple();
        $this->form->close();

        $expected = '<select id="test-sports" name="sports" multiple><option value="0">Basketball</option><option value="1">Football</option><option value="2">Tennis</option></select>';
        $this->assertEquals($this->clean($this->form->sports->field()), $expected);
    }

    public function testPopulatedMultiSelectElement()
    {
        $this->setPostValue('sports', [0,1]);

        $this->form->open('test');
        $this->form->select('sports')->options(['Basketball', 'Football', 'Tennis'])->multiple();
        $this->form->close();

        $expected = '<select id="test-sports" name="sports" multiple><option value="0" selected>Basketball</option><option value="1" selected>Football</option><option value="2">Tennis</option></select>';
        $this->assertEquals($this->clean($this->form->sports->field()), $expected);
    }

    public function testCheckBoxElement()
    {
        $this->form->open('test');
        $this->form->checkbox('confirmed');
        $this->form->close();

        $expected = '<input id="test-confirmed" name="confirmed" value="1" />';
        $this->assertEquals($this->form->confirmed->field(), $expected);
    }

    public function testCheckedCheckBox()
    {
        $this->setPostValue('confirmed', 1);

        $this->form->open('test');
        $this->form->checkbox('confirmed');
        $this->form->close();

        $expected = '<input id="test-confirmed" name="confirmed" value="1" checked />';
        $this->assertEquals($this->form->confirmed->field(), $expected);
    }

    public function testCheckedByDefaultCheckBox()
    {
        $this->form->open('test');
        $this->form->checkbox('confirmed')->checked();
        $this->form->close();

        $expected = '<input id="test-confirmed" name="confirmed" value="1" checked />';
        $this->assertEquals($this->form->confirmed->field(), $expected);

        $this->setPostValue('_form', 'test'); // fake submit

        $expected = '<input id="test-confirmed" name="confirmed" value="1" />';
        $this->assertEquals($this->form->confirmed->field(), $expected);
    }

    public function testCustomValueCheckBox()
    {
        $this->form->open('test');
        $this->form->checkbox('confirmed')->value('yes');
        $this->form->close();

        $expected = '<input id="test-confirmed" name="confirmed" value="yes" />';
        $this->assertEquals($this->form->confirmed->field(), $expected);
    }
}