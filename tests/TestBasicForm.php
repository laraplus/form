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
}