<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Contracts\DataStore;
use Laraplus\Form\Contracts\FormPresenter;

class Close
{
    /**
     * @var Open
     */
    protected $open;

    /**
     * @var DataStore
     */
    protected $data;

    /**
     * @var bool
     */
    protected $token;

    /**
     * @var FormPresenter
     */
    protected $presenter;

    /**
     * @param Open $open
     * @param DataStore $data
     * @param FormPresenter $presenter
     */
    public function __construct(Open $open, DataStore $data, FormPresenter $presenter)
    {
        $this->open = $open;
        $this->data = $data;
        $this->token = true;
        $this->presenter = $presenter;
    }

    /**
     * @return $this
     */
    public function noToken()
    {
        $this->token = false;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->open->bare) {
            return '';
        }

        $tag = $this->presenter->renderClosingTag($this);

        if ($this->token) {
            $tag = '<input type="hidden" name="_token" value="' . $this->data->getToken() . '" />' . $tag;
        }

        return $tag;
    }
}