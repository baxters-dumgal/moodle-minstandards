<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Minimum Standards activity module for Moodle.
 *
 * @package     mod_minstandards
 * @copyright   2026 Dumfries and Galloway College
 * @author      baxters@dumgal.ac.uk
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$id = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id(
    'minstandards',
    $id,
    0,
    false,
    MUST_EXIST
);

$course = get_course($cm->course);

$minstandards = $DB->get_record(
    'minstandards',
    ['id' => $cm->instance],
    '*',
    MUST_EXIST
);

require_login($course, true, $cm);

$context = context_module::instance($cm->id);

require_capability(
    'mod/minstandards:editrubric',
    $context
);

$PAGE->set_url('/mod/minstandards/view.php', ['id' => $cm->id]);
$PAGE->set_title($minstandards->name);
$PAGE->set_heading($course->fullname);
$PAGE->set_context($context);

$canedit = has_capability(
    'mod/minstandards:editchecklist',
    $context
);

$tab = optional_param( 'tab', 'checklist', PARAM_ALPHA );


$tabs = [];

$tabs[] = new tabobject(
    'checklist',
    new moodle_url(
        '/mod/minstandards/view.php',
        [
            'id' => $cm->id,
            'tab' => 'checklist'
        ]
    ),
    get_string('minimumstandards', 'minstandards')
);

$tabs[] = new tabobject(
    'rubric',
    new moodle_url(
        '/mod/minstandards/view.php',
        [
            'id' => $cm->id,
            'tab' => 'rubric'
        ]
    ),
    get_string('selfreflectionrubric', 'minstandards')
);

$tabs[] = new tabobject( 
    'guidance', 
    new moodle_url( '/mod/minstandards/view.php', 
    [ 
        'id' => $cm->id, 
        'tab' => 'guidance' 
        
    ] ), 
    get_string('guidancetab', 'minstandards') 
);

print_tabs(
    [$tabs],
    $tab
);



/*
|--------------------------------------------------------------------------
| Get rubric record
|--------------------------------------------------------------------------
*/

$rubric = $DB->get_record(
    'minstandards_rubric',
    ['minstandardsid' => $minstandards->id]
);

/*
|--------------------------------------------------------------------------
| Create empty rubric if none exists
|--------------------------------------------------------------------------
*/

if (!$rubric) {

    $rubric = new stdClass();

    $rubric->minstandardsid = $minstandards->id;

    $rubric->welcomeinfo = 0;
    $rubric->grammar = 0;
    $rubric->presentation = 0;
    $rubric->learningresources = 0;
    $rubric->completion = 0;
    $rubric->assessment_rubric = 0;
    $rubric->accessibility_rubric = 0;
    $rubric->digitaltools = 0;
    $rubric->multimedia = 0;

    $rubric->totalscore = 0;

    $rubric->useridmodified = $USER->id;
    $rubric->timecreated = time();
    $rubric->timemodified = time();

    $rubric->id = $DB->insert_record(
        'minstandards_rubric',
        $rubric
    );
}



/*
|--------------------------------------------------------------------------
| Get checklist record
|--------------------------------------------------------------------------
*/

$checklist = $DB->get_record(
    'minstandards_checklist',
    ['minstandardsid' => $minstandards->id]
);

/*
|--------------------------------------------------------------------------
| Create empty checklist if none exists
|--------------------------------------------------------------------------
*/

if (!$checklist) {

    $checklist = new stdClass();

    $checklist->minstandardsid = $minstandards->id;

    $checklist->clearstructure = 0;
    $checklist->moduledescription = 0;
    $checklist->staffcontact = 0;
    $checklist->accessibility = 0;
    $checklist->communication = 0;
    $checklist->resources = 0;
    $checklist->assessment = 0;
    $checklist->feedback = 0;
    $checklist->uptodatecontent = 0;
    $checklist->expectations = 0;

    $checklist->interactivity = 0;
    $checklist->flexibility = 0;
    $checklist->collaboration = 0;

    $checklist->notes = '';

    $checklist->useridmodified = $USER->id;
    $checklist->timecreated = time();
    $checklist->timemodified = time();

    $checklist->id = $DB->insert_record(
        'minstandards_checklist',
        $checklist
    );
}

/*
|--------------------------------------------------------------------------
| Save form
|--------------------------------------------------------------------------
*/

if (
    $canedit &&
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    confirm_sesskey()
) {

    /*
    |--------------------------------------------------------------------------
    | Save checklist
    |--------------------------------------------------------------------------
    */

    if ($tab === 'checklist') {

        $checklist->clearstructure =
            optional_param('clearstructure', 0, PARAM_INT);

        $checklist->moduledescription =
            optional_param('moduledescription', 0, PARAM_INT);

        $checklist->staffcontact =
            optional_param('staffcontact', 0, PARAM_INT);

        $checklist->accessibility =
            optional_param('accessibility', 0, PARAM_INT);

        $checklist->communication =
            optional_param('communication', 0, PARAM_INT);

        $checklist->resources =
            optional_param('resources', 0, PARAM_INT);

        $checklist->assessment =
            optional_param('assessment', 0, PARAM_INT);

        $checklist->feedback =
            optional_param('feedback', 0, PARAM_INT);

        $checklist->uptodatecontent =
            optional_param('uptodatecontent', 0, PARAM_INT);

        $checklist->expectations =
            optional_param('expectations', 0, PARAM_INT);

        $checklist->interactivity =
            optional_param('interactivity', 0, PARAM_INT);

        $checklist->flexibility =
            optional_param('flexibility', 0, PARAM_INT);

        $checklist->collaboration =
            optional_param('collaboration', 0, PARAM_INT);

        $checklist->notes =
            optional_param('notes', '', PARAM_TEXT);

        $checklist->useridmodified = $USER->id;
        $checklist->timemodified = time();

        $DB->update_record(
            'minstandards_checklist',
            $checklist
        );

        /*
         * Trigger checklist event
         */
        $event = \mod_minstandards\event\checklist_updated::create([
            'objectid' => $checklist->id,
            'context' => $context
        ]);

        $event->add_record_snapshot(
            'minstandards_checklist',
            $checklist
        );

        $event->trigger();
    }

    /*
    |--------------------------------------------------------------------------
    | Save rubric
    |--------------------------------------------------------------------------
    */

    if ($tab === 'rubric') {

        $rubric->welcomeinfo =
            optional_param('welcomeinfo', 0, PARAM_INT);

        $rubric->grammar =
            optional_param('grammar', 0, PARAM_INT);

        $rubric->presentation =
            optional_param('presentation', 0, PARAM_INT);

        $rubric->learningresources =
            optional_param('learningresources', 0, PARAM_INT);

        $rubric->completion =
            optional_param('completion', 0, PARAM_INT);

        $rubric->assessment_rubric = optional_param( 'assessment_rubric', 0, PARAM_INT );

        $rubric->accessibility_rubric = optional_param( 'accessibility_rubric', 0, PARAM_INT );

        $rubric->digitaltools =
            optional_param('digitaltools', 0, PARAM_INT);

        $rubric->multimedia =
            optional_param('multimedia', 0, PARAM_INT);

        /*
         * Calculate total
         */
        $rubric->totalscore =
            $rubric->welcomeinfo +
            $rubric->grammar +
            $rubric->presentation +
            $rubric->learningresources +
            $rubric->completion +
            $rubric->assessment_rubric + 
            $rubric->accessibility_rubric +
            $rubric->digitaltools +
            $rubric->multimedia;

        $rubric->useridmodified = $USER->id;
        $rubric->timemodified = time();

        $DB->update_record(
            'minstandards_rubric',
            $rubric
        );

        /*
        |--------------------------------------------------------------------------
        | Trigger rubric event
        |--------------------------------------------------------------------------
        */

        $event = \mod_minstandards\event\rubric_updated::create([
            'objectid' => $rubric->id,
            'context' => $context
        ]);

        $event->add_record_snapshot(
            'minstandards_rubric',
            $rubric
        );

        $event->trigger();
        }

        redirect(
            new moodle_url(
                '/mod/minstandards/view.php',
                [
                    'id' => $cm->id,
                    'tab' => $tab
                ]
            ),
            get_string('changessaved')
        );
}



/*
|--------------------------------------------------------------------------
| Render page
|--------------------------------------------------------------------------
*/

echo $OUTPUT->header();

echo $OUTPUT->heading(
    get_string('checklisttab', 'minstandards')
);

$tabs = [];

$tabs[] = html_writer::link(
    new moodle_url(
        '/mod/minstandards/view.php',
        [
            'id' => $cm->id,
            'tab' => 'checklist'
        ]
    ),
    get_string('checklisttab', 'minstandards'),
    [
        'class' =>
            'nav-link ' .
            ($tab === 'checklist' ? 'active' : '')
    ]
   
);

if (has_capability(
    'mod/minstandards:viewrubric',
    $context
)) {

    $tabs[] = html_writer::link(
        new moodle_url(
            '/mod/minstandards/view.php',
            [
                'id' => $cm->id,
                'tab' => 'rubric'
            ]
        ),
        get_string('rubrictab', 'minstandards'),
        [
            'class' =>
                'nav-link ' .
                ($tab === 'rubric' ? 'active' : '')
        ]
    );
}

$tabs[] = html_writer::link(
        new moodle_url(
            '/mod/minstandards/view.php',
            [
                'id' => $cm->id,
                'tab' => 'guidance'
            ]
        ),
        get_string('guidancetab', 'minstandards'),
        [
            'class' =>
                'nav-link ' .
                ($tab === 'guidance' ? 'active' : '')
        ]
);

echo html_writer::start_tag(
    'ul',
    ['class' => 'nav nav-tabs mb-4']
);

foreach ($tabs as $tabhtml) {

    echo html_writer::tag(
        'li',
        $tabhtml,
        ['class' => 'nav-item']
    );
}

echo html_writer::end_tag('ul');



if ($tab === 'guidance') { 


    /*
    |--------------------------------------------------------------------------
    | Guidance accordion
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_div(
        'accordion mb-4',
        ['id' => 'guidanceaccordion']
    );

    /*
    |--------------------------------------------------------------------------
    | Accordion item 1
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_div('card');

    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    echo html_writer::tag(
        'h2',
        html_writer::tag(
            'button',
            get_string('checklistguidance', 'minstandards'),
            [
                'class' => 'btn btn-link text-start w-100',
                'type' => 'button',
                'data-toggle' => 'collapse',
                'data-target' => '#checklistguidance',
                'aria-expanded' => 'false',
                'aria-controls' => 'checklistguidance'
            ]
        ),
        [ 'class' => 'card-header', 'id' => 'headingchecklist' ]
    );

    /*
    |--------------------------------------------------------------------------
    | Collapsible body
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_div(
        'collapse',
        [
            'id' => 'checklistguidance',
            'data-bs-parent' => '#guidanceaccordion',
            'aria-labelledby' => 'headingchecklist'
        ]
    );

    echo html_writer::start_div('card-body');

    /*
    |--------------------------------------------------------------------------
    | Explanation text
    |--------------------------------------------------------------------------
    */

    echo html_writer::div(
        get_string('checklistguidanceintro', 'minstandards'),
        'mb-4'
    );

    /*
    |--------------------------------------------------------------------------
    | Guidance table
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag(
        'table',
        ['class' => 'table table-striped table-bordered']
    );

    /*
    |--------------------------------------------------------------------------
    | Table header
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag('thead');

    echo html_writer::tag(
        'tr',
        html_writer::tag('th', 'Area') .
        html_writer::tag('th', 'Minimum Expectation') .
        html_writer::tag('th', 'Examples / Guidance')
    );

    echo html_writer::end_tag('thead');

    /*
    |--------------------------------------------------------------------------
    | Table body
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag('tbody');

    /*
    |--------------------------------------------------------------------------
    | Detail rows
    |--------------------------------------------------------------------------
    */

    minstandards_render_guidance_row( 'clearstructure' ); 
    minstandards_render_guidance_row( 'moduledescription' ); 
    minstandards_render_guidance_row( 'staffcontact' );
    minstandards_render_guidance_row( 'accessibility' );
    minstandards_render_guidance_row( 'communication' );
    minstandards_render_guidance_row( 'resources' );
    minstandards_render_guidance_row( 'assessment' );
    minstandards_render_guidance_row( 'feedback' );
    minstandards_render_guidance_row( 'uptodatecontent' );
    minstandards_render_guidance_row( 'expectations' );
    minstandards_render_guidance_row( 'interactivity' );
    minstandards_render_guidance_row( 'flexibility' );
    minstandards_render_guidance_row( 'collaboration' );


    echo html_writer::end_tag('tbody');

    echo html_writer::end_tag('table');

    /*
    |--------------------------------------------------------------------------
    | Close accordion body
    |--------------------------------------------------------------------------
    */

    echo html_writer::end_div();

    /*
    |--------------------------------------------------------------------------
    | Close collapse
    |--------------------------------------------------------------------------
    */

    echo html_writer::end_div();

    /*
    |--------------------------------------------------------------------------
    | Close accordion item
    |--------------------------------------------------------------------------
    */

    echo html_writer::end_div();

   



    /*
    |--------------------------------------------------------------------------
    | Accordion item 2 - Rubric guidance
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_div('card');

    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    echo html_writer::tag(
        'h2',
        html_writer::tag(
            'button',
            get_string('rubricguidance', 'minstandards'),
            [
                'class' => 'btn btn-link text-start w-100',
                'type' => 'button',
                'data-toggle' => 'collapse',
                'data-target' => '#rubricguidance',
                'aria-expanded' => 'false',
                'aria-controls' => 'rubricguidance'
            ]
        ),
        [ 'class' => 'card-header', 'id' => 'headingrubric' ]
    );

    /*
    |--------------------------------------------------------------------------
    | Collapse body
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_div(
        'collapse',
        [
            'id' => 'rubricguidance',
            'data-bs-parent' => '#guidanceaccordion',
            'aria-labelledby' => 'headingrubric'
        ]
    );

    echo html_writer::start_div('card-body');

    /*
    |--------------------------------------------------------------------------
    | Intro text
    |--------------------------------------------------------------------------
    */

    echo html_writer::div(
        get_string('rubricguidanceintro', 'minstandards'),
        'mb-4'
    );

   

    /*
    |--------------------------------------------------------------------------
    | Rubric guidance table
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag(
        'table',
        ['class' => 'table table-striped table-bordered']
    );

    /*
    |--------------------------------------------------------------------------
    | Table header
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag('thead');

    echo html_writer::tag(
    'tr',
    html_writer::tag('th', 'Criterion') .
    html_writer::tag('th', 'Detail') .
    html_writer::tag('th', '0') .
    html_writer::tag('th', '1') .
    html_writer::tag('th', '2') .
    html_writer::tag('th', '3')
    );

    echo html_writer::end_tag('thead');

    /*
    |--------------------------------------------------------------------------
    | Table body
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag('tbody');

    /*
    |--------------------------------------------------------------------------
    | Example rows
    |--------------------------------------------------------------------------
    */

    minstandards_render_rubric_score_row('welcomeinfo');
    minstandards_render_rubric_score_row('grammar');
    minstandards_render_rubric_score_row('presentation');

    minstandards_render_rubric_score_row('learningresources');
    minstandards_render_rubric_score_row('completion');
    minstandards_render_rubric_score_row('assessment_rubric');
    minstandards_render_rubric_score_row('accessibility_rubric');
    minstandards_render_rubric_score_row('digitaltools');

    minstandards_render_rubric_score_row('multimedia');


    /*
    |--------------------------------------------------------------------------
    | Add remaining rows here
    |--------------------------------------------------------------------------
    */

    echo html_writer::end_tag('tbody');

    echo html_writer::end_tag('table');

    echo html_writer::end_div();

    echo html_writer::end_div();

    echo html_writer::end_div();


     /*
    |--------------------------------------------------------------------------
    | End accordion
    |--------------------------------------------------------------------------
    */

    echo html_writer::end_div();




}





if ($tab === 'checklist') {

    /*
    |--------------------------------------------------------------------------
    | Form start
    |--------------------------------------------------------------------------
    */
    echo html_writer::start_tag('form', [
        'method' => 'post',
        'action' => new moodle_url(
            '/mod/minstandards/view.php',
            [
                'id' => $cm->id,
                'tab' => $tab
            ]
        )
    ]);

    echo html_writer::empty_tag('input', [
        'type' => 'hidden',
        'name' => 'sesskey',
        'value' => sesskey()
    ]);

    echo html_writer::start_div('card mb-4');

    echo html_writer::div( get_string('checklistintro', 'minstandards'), 'alert alert-info mb-4' );

    echo html_writer::div(
        get_string('essential', 'minstandards'),
        'card-header bg-danger-subtle fw-bold'
    );

    echo html_writer::start_div('card-body p-0');

    

    echo html_writer::start_tag(
        'table',
        ['class' => 'table table-striped mb-0']
    );

    /*
    |--------------------------------------------------------------------------
    | Column widths
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag('colgroup');

    echo html_writer::tag(
        'col',
        '',
        ['style' => 'width: 60px;']
    );

    echo html_writer::tag(
        'col',
        '',
        ['style' => 'width: auto;']
    );

    echo html_writer::end_tag('colgroup');

    /*
    |--------------------------------------------------------------------------
    | Essential section
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag('tbody');

    minstandards_render_check_row('clearstructure', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('moduledescription', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('staffcontact', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('accessibility', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('communication', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('resources', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('assessment', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('feedback', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('uptodatecontent', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('expectations', $checklist, $canedit, $OUTPUT);

    echo html_writer::end_tag('tbody');

    echo html_writer::end_tag('table');

    echo html_writer::end_div();

    echo html_writer::end_div();



    /*
    |--------------------------------------------------------------------------
    | Desirable section
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_div('card mb-4');

    echo html_writer::div(
        get_string('desirable', 'minstandards'),
        'card-header bg-info-subtle fw-bold'
    );

    echo html_writer::start_div('card-body p-0');

    echo html_writer::start_tag(
        'table',
        ['class' => 'table table-striped mb-0']
    );

    /*
    |--------------------------------------------------------------------------
    | Column widths
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_tag('colgroup');

    echo html_writer::tag(
        'col',
        '',
        ['style' => 'width: 60px;']
    );

    echo html_writer::tag(
        'col',
        '',
        ['style' => 'width: auto;']
    );

    echo html_writer::end_tag('colgroup');    

    echo html_writer::start_tag('tbody');

    minstandards_render_check_row('interactivity', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('flexibility', $checklist, $canedit, $OUTPUT);
    minstandards_render_check_row('collaboration', $checklist, $canedit, $OUTPUT);

    echo html_writer::end_tag('tbody');
    echo html_writer::end_tag('table');
    echo html_writer::end_div();
    echo html_writer::end_div();



    /*
    |--------------------------------------------------------------------------
    | Notes
    |--------------------------------------------------------------------------
    */

    echo html_writer::start_div('card mb-4');

    echo html_writer::div(
        get_string('notes', 'minstandards'),
        'card-header fw-bold'
    );

    echo html_writer::start_div('card-body');

    echo html_writer::tag(
        'textarea',
        s($checklist->notes),
        [
            'name' => 'notes',
            'rows' => 6,
            'class' => 'form-control',
            'readonly' => $canedit ? null : 'readonly'
        ]
    );

    echo html_writer::end_div();

    echo html_writer::end_div();


    /*
    |--------------------------------------------------------------------------
    | Save button
    |--------------------------------------------------------------------------
    */

    if ($canedit) {

        echo html_writer::empty_tag('br');

        echo html_writer::empty_tag('input', [
            'type' => 'submit',
            'value' => get_string(
                'savechecklist',
                'minstandards'
            ),
            'class' => 'btn btn-primary'
        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Timestamp
    |--------------------------------------------------------------------------
    */

    echo html_writer::tag(
        'p',
        get_string('lastupdated', 'minstandards') .
        ': ' .
        userdate($checklist->timemodified)
    );

   

    echo html_writer::end_tag('form');

  

} // End of checklist


if ($tab === 'rubric') {

  echo html_writer::start_tag('form', [
        'method' => 'post',
        'action' => new moodle_url(
            '/mod/minstandards/view.php',
            [
                'id' => $cm->id,
                'tab' => 'rubric'
            ]
        )
    ]);

    echo html_writer::empty_tag('input', [
        'type' => 'hidden',
        'name' => 'sesskey',
        'value' => sesskey()
    ]);

    echo html_writer::start_div('card');

    echo html_writer::div(
        get_string('rubrictab', 'minstandards'),
        'card-header bg-primary-subtle fw-bold'
    );

    echo html_writer::start_div('card-body p-0');

    echo html_writer::div( get_string('rubricintro', 'minstandards'), 'alert alert-info mb-4' );

    echo html_writer::start_tag(
        'table',
        ['class' => 'table table-striped table-hover align-middle mb-0']
    );

    echo html_writer::start_tag('thead');

    echo html_writer::start_tag('tr');

    echo html_writer::tag(
        'th',
        get_string('element', 'minstandards')
    );

    /*
    |--------------------------------------------------------------------------
    | Score headings with tooltips
    |--------------------------------------------------------------------------
    */

    for ($i = 0; $i <= 3; $i++) {

        $tooltip = get_string(
            'score' . $i . 'desc',
            'minstandards'
        );

        echo html_writer::tag(
            'th',
            html_writer::tag(
                'span',
                $i,
                [
                    
                    'title' => $tooltip,
                    'class' => 'd-inline-block text-decoration-underline text-center', 
                    'style' => 'cursor: help; width: 100%;'
                ]
            ),
            ['class' => 'text-center']
        );
    }

    echo html_writer::end_tag('tr');


    echo html_writer::end_tag('thead');




    echo html_writer::start_tag('tbody');



    minstandards_render_rubric_row(
        'welcomeinfo',
        $rubric,
        $canedit,
        $OUTPUT
    );

    minstandards_render_rubric_row(
        'grammar',
        $rubric,
        $canedit,
        $OUTPUT
    );

    minstandards_render_rubric_row(
        'presentation',
        $rubric,
        $canedit,
        $OUTPUT
    );

    minstandards_render_rubric_row(
        'learningresources',
        $rubric,
        $canedit,
        $OUTPUT
    );

    minstandards_render_rubric_row(
        'completion',
        $rubric,
        $canedit,
        $OUTPUT
    );

    minstandards_render_rubric_row(
        'assessment_rubric',
        $rubric,
        $canedit,
        $OUTPUT
    );

    minstandards_render_rubric_row(
        'accessibility_rubric',
        $rubric,
        $canedit,
        $OUTPUT
    );

    minstandards_render_rubric_row(
        'digitaltools',
        $rubric,
        $canedit,
        $OUTPUT
    );

    minstandards_render_rubric_row(
        'multimedia',
        $rubric,
        $canedit,
        $OUTPUT
    );

    echo html_writer::end_tag('tbody');

    echo html_writer::end_tag('table');

    echo html_writer::end_div();

    /*
    |--------------------------------------------------------------------------
    | Total score
    |--------------------------------------------------------------------------
    */

    if ($rubric->totalscore >= 22) { 
        $scoreclass = 'bg-success'; 
    } 
    else if ($rubric->totalscore >= 14)   { 
        $scoreclass = 'bg-warning text-dark'; } 
    else   { 
        $scoreclass = 'bg-danger'; 
    }

    echo html_writer::div( html_writer::tag( 'span', 
        get_string('totalscore', 'minstandards') . ': ' . $rubric->totalscore . '/27', 
        ['class' => "badge {$scoreclass} fs-5"] ), 'text-end mt-3' );

    echo html_writer::end_div();

    /*
    |--------------------------------------------------------------------------
    | Save button
    |--------------------------------------------------------------------------
    */

    if ($canedit) {

        echo html_writer::empty_tag('br');

        echo html_writer::empty_tag('input', [
            'type' => 'submit',
            'value' => get_string(
                'saverubric',
                'minstandards'
            ),
            'class' => 'btn btn-primary'
        ]);
    }

    echo html_writer::end_tag('form');


  
}

$PAGE->requires->jquery();

$PAGE->requires->js_init_code(" require(['jquery'], function($) { $('.collapse').collapse(); }); ");

echo $OUTPUT->footer();