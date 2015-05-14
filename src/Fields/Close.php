<?php namespace Laraplus\Form\Fields;

use Exception;
use Laraplus\Form\Contracts\DataStore;

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
     * @param Open $open
     * @param DataStore $data
     */
    public function __construct(Open $open, DataStore $data)
    {
        $this->open = $open;
        $this->data = $data;
        $this->token = true;
    }

    /**
     * @return $this
     */
    public function withoutToken()
    {
        $this->token = false;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $tag = '</form>';

        if($this->token) {
            $tag = '<input type="hidden" name="_token" value="' . $this->data->getToken() . '" />' . $tag;
        }

        return $tag;
    }
}