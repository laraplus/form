<?php

use Laraplus\Form\Form;
use Laraplus\Form\DataStores\PhpDataStore;
use Laraplus\Form\Presenters\Bootstrap3Presenter;
use Laraplus\Form\ConfigProviders\PhpConfigProvider;

require '../vendor/autoload.php';

$dataStore = new PhpDataStore();
$presenter = new Bootstrap3Presenter();
$configProvider = new PhpConfigProvider(require '../config/form.php');

$form = new Form($presenter, $dataStore, $configProvider);