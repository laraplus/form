<?php

class TestListElements extends TestCase
{
    public function testStackedRadioList()
    {
        $this->form->open('test');
        $this->form->checklist('gender')->options(['name' => 'Male', 'female' => 'Female']);
        $this->form->close();

        $expected = '<div><input value="name" type="radio" name="gender" /> Male</div><div><input value="female" type="radio" name="gender" /> Female</div>';
        $this->assertEquals($this->form->gender->field(), $expected);
    }

    public function testInlineRadioList()
    {
        $this->form->open('test');
        $this->form->checklist('gender')->options(['name' => 'Male', 'female' => 'Female'])->inline();
        $this->form->close();

        $expected = '<span><input value="name" type="radio" name="gender" /> Male</span><span><input value="female" type="radio" name="gender" /> Female</span>';
        $this->assertEquals($this->form->gender->field(), $expected);
    }

    public function testStackedCheckboxList()
    {
        $this->form->open('test');
        $this->form->checklist('interests')->options(['Football', 'Basketball'])->multiple();
        $this->form->close();

        $expected = '<div><input value="0" type="checkbox" name="interests[0]" /> Football</div><div><input value="1" type="checkbox" name="interests[1]" /> Basketball</div>';
        $this->assertEquals($this->form->interests->field(), $expected);
    }
}