<?php

return [

    'presenter'  => 'Laraplus\Form\Presenters\BulmaPresenter',
    'style'      => 'vertical',
    'styles'     => [
        'horizontal' => [
            'form'             => null,
            'label'            => 'label',
            'label-radio'      => 'radio',
            'label-checkbox'   => 'checkbox',
            'element'          => 'is-expanded',
            'field'            => 'is-horizontal',
            'required'         => ' *',
            'success-status'   => true
        ],
        'vertical'   => [
            'form'             => null,
            'label'            => 'label',
            'label-radio'      => 'radio',
            'label-checkbox'   => 'checkbox',
            'element'          => 'is-expanded',
            'field'            => null,
            'required'         => ' *',
            'success-status'   => true
        ],
        'inline'     => [
            'form'             => null,
            'label'            => 'label',
            'label-radio'      => 'radio',
            'label-checkbox'   => 'checkbox',
            'element'          => 'is-expanded',
            'field'            => 'is-inline-flex-tablet',
            'required'         => ' *',
            'success-status'   => true
        ]
    ]
];