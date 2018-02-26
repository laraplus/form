<?php

return [

    'presenter'  => 'Laraplus\Form\Presenters\BulmaPresenter',
    'style'      => 'horizontal',
    'styles'     => [
        'horizontal' => [
            'form'             => null,
            'label'            => 'label',
            'label-radio'      => 'radio',
            'label-checkbox'   => 'checkbox',
            'element'          => 'is-expanded',
            'field'            => 'is-horizontal',
            'required'         => ' *'
        ],
        'vertical'   => [
            'form'             => null,
            'label'            => 'label',
            'label-radio'     => 'radio',
            'label-checkbox'   => 'checkbox',
            'element'          => 'is-expanded',
            'field'            => null,
            'required'         => ' *'
        ],
        'inline'     => [
            'form'             => null,
            'label'            => 'label',
            'label-radio'     => 'radio',
            'label-checkbox'   => 'checkbox',
            'element'          => 'is-expanded',
            'field'            => 'is-inline-flex-tablet',
            'required'         => ' *'
        ]
    ]
];