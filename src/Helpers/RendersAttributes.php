<?php namespace Laraplus\Form\Helpers;

trait RendersAttributes
{
    /**
     * @param array $attributes
     * @return string
     */
    protected function renderAttributes(array $attributes)
    {
        $result = [];

        foreach ($attributes as $key => $value) {
            $encoded = htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false);
            
            $result[] = $key . (strlen($value) ? '="' . $encoded . '"' : '');
        }

        return $result ? ' ' . implode(' ', $result) : '';
    }
}
