<?php

return [

    'presenter' => 'Laraplus\Form\Presenters\Bootstrap3Presenter',
    'style'     => 'horizontal',
    'styles'    => [
        'horizontal' => [
            'form'           => 'form-horizontal',
            'label'          => 'col-sm-2 control-label',
            'element'        => 'col-sm-10',
            'no_label'       => 'col-sm-10 col-sm-offset-2',
            'required'       => ' *',
            'success-status' => true
        ],
        'vertical'   => [
            'form'           => null,
            'label'          => null,
            'element'        => null,
            'required'       => ' *',
            'success-status' => true
        ],
        'inline'     => [
            'form'           => 'form-inline',
            'label'          => null,
            'element'        => null,
            'required'       => ' *',
            'success-status' => true
        ]
    ]
];