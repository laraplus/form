<?php namespace Laraplus\Form\Contracts;

interface ConfigProvider
{
	/**
	 * Get configuration by key
	 *
	 * @param $key
	 * @return mixed
	 */
	public function get($key);
}