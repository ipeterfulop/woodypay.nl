<?php

return [
    //default button labels and classes can be set up here
    //when generating the button faces, the __label__ placeholder in the html string
    //will be replaced by the translationLabel ran through the __ function
    'buttons' => [
        'details' => [
            'class'       => 'btn btn-outline-primary',
            'html'        => '<span title="__label__">'.config('heroicons.outline.dots-horizontal').'</span>',
            'translationLabel' => 'Details',
        ],
        'edit'   => [
            'class'       => 'btn btn-outline-secondary',
            'html'        => '<span title="__label__">'.config('heroicons.outline.pencil').'</span>',
            'translationLabel' => 'Edit',
        ],
        'delete' => [
            'class'       => 'btn btn-outline-danger',
            'html'        => '<span title="__label__">'.config('heroicons.outline.trash').'</span>',
            'translationLabel' => 'Delete',
        ],
        'confirmDeletion' => [
            'class'       => 'bg-red-600 text-white',
            'html'        => '<span title="__label__">'.config('heroicons.outline.trash').'</span>',
            'translationLabel' => 'Delete',
        ],
        'moveUp' => [
            'class'       => 'btn btn-outline-secondary',
            'html'        => config('heroicons.outline.arrow-up'),
        ],
        'moveDown' => [
            'class'       => 'btn btn-outline-secondary',
            'html'        => config('heroicons.outline.arrow-down'),
        ],

    ],
    'vueCrudDefaultView' => 'admin.vue-crud.model-manager',
    'modelManagerClassOverrides' => [
        'edit-form-step-head-inactive' => 'portlet-heading bg-inverse',
        'edit-form-step-head' => 'portlet-heading bg-primary',
        'edit-form-step-body' => 'panel p-2 flex flex-row flex-wrap',
        'edit-form-step' => 'portlet',
        'model-manager-filters-heading' => 'bg-gray-200 text-gray-900 flex justify-between',
        'model-manager-main-heading' => 'bg-gray-200 text-gray-900 flex justify-between',
        'model-manager-table-head' => 'bg-gray-200 text-gray-900',
        'model-manager-edit-window-heading' => 'bg-gray-200 text-gray-900',
        'model-manager-create-window-heading' => 'bg-gray-200 text-gray-900',
        'edit-form-form-buttons-container' => 'w-full flex justify-between',
    ]

];
