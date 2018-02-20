<?php

use Laraplus\Form\Form;
use Laraplus\Form\DataStores\PhpDataStore;
use Laraplus\Form\ConfigProviders\PhpConfigProvider;
use Laraplus\Form\Presenters\BulmaPresenter;

require '../vendor/autoload.php';

$dataStore = new PhpDataStore();
$presenter = new BulmaPresenter();
$configProvider = new PhpConfigProvider(require '../config/form.php');

$form = new Form($presenter, $dataStore, $configProvider);