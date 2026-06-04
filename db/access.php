<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = [

    /*
     * Add the activity
     */
    'mod/minstandards:addinstance' => [

        'captype' => 'read',

        'contextlevel' => CONTEXT_MODULE,

        'archetypes' => [
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ]
    ],

    /*
     * View the activity
     */
    'mod/minstandards:view' => [

        'captype' => 'read',

        'contextlevel' => CONTEXT_MODULE,

        'archetypes' => [
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ]
    ],

    /*
     * Edit the checklist tab
     */
    'mod/minstandards:editchecklist' => [

        'captype' => 'write',

        'contextlevel' => CONTEXT_MODULE,

        'archetypes' => [
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ]
    ],

    /*
     * View the reflective rubric
     */
    'mod/minstandards:viewrubric' => [

        'captype' => 'read',

        'contextlevel' => CONTEXT_MODULE,

        'archetypes' => [
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ]
    ],

    /*
     * Edit the reflective rubric
     */
    'mod/minstandards:editrubric' => [

        'captype' => 'write',

        'contextlevel' => CONTEXT_MODULE,

        'archetypes' => [
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ]
    ]

];
