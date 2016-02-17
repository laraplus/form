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
            $result[] = $key . ($value ? '="' . $value . '"' : '');
        }

        return $result ? ' ' . implode(' ', $result) : '';
    }
}