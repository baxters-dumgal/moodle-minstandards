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
    'mod/minstandards:view',
    $context
);

$PAGE->set_url('/mod/minstandards/view.php', ['id' => $cm->id]);
$PAGE->set_title($minstandards->name);
$PAGE->set_heading($course->fullname);

$canedit = has_capability(
    'mod/minstandards:editchecklist',
    $context
);

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

    $event = \mod_minstandards\event\checklist_updated::create([
        'objectid' => $checklist->id,
        'context' => $context
    ]);

    $event->add_record_snapshot(
        'minstandards_checklist',
        $checklist
    );

    $event->trigger();

    redirect(
        new moodle_url(
            '/mod/minstandards/view.php',
            ['id' => $cm->id]
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

/*
|--------------------------------------------------------------------------
| Form start
|--------------------------------------------------------------------------
*/

echo html_writer::start_tag('form', [
    'method' => 'post'
]);

echo html_writer::empty_tag('input', [
    'type' => 'hidden',
    'name' => 'sesskey',
    'value' => sesskey()
]);

/*
|--------------------------------------------------------------------------
| Essential section
|--------------------------------------------------------------------------
*/


echo html_writer::start_div('card mb-4');

echo html_writer::div(
    get_string('essential', 'minstandards'),
    'card-header bg-danger-subtle fw-bold'
);

echo html_writer::start_div('card-body p-0');

echo html_writer::start_tag(
    'table',
    ['class' => 'table table-striped mb-0']
);

echo html_writer::start_tag('tbody');

render_check_row('clearstructure', $checklist, $canedit, $OUTPUT);
render_check_row('moduledescription', $checklist, $canedit, $OUTPUT);
render_check_row('staffcontact', $checklist, $canedit, $OUTPUT);
render_check_row('accessibility', $checklist, $canedit, $OUTPUT);
render_check_row('communication', $checklist, $canedit, $OUTPUT);
render_check_row('resources', $checklist, $canedit, $OUTPUT);
render_check_row('assessment', $checklist, $canedit, $OUTPUT);
render_check_row('feedback', $checklist, $canedit, $OUTPUT);
render_check_row('uptodatecontent', $checklist, $canedit, $OUTPUT);
render_check_row('expectations', $checklist, $canedit, $OUTPUT);

echo html_writer::end_tag('tbody');

echo html_writer::end_tag('table');

echo html_writer::end_div();

echo html_writer::end_div();



/*
|--------------------------------------------------------------------------
| Checkbox helper
|--------------------------------------------------------------------------
*/



function render_check_row(
    $name,
    $checklist,
    $canedit,
    $OUTPUT
) {

    echo html_writer::start_tag('tr');

    /*
     * Checkbox column
     */
    echo html_writer::tag(
        'td',
        html_writer::checkbox(
            $name,
            1,
            !empty($checklist->$name),
            '',
            $canedit ? [] : ['disabled' => 'disabled']
        ),
        ['class' => 'text-center align-middle']
    );

    /*
     * Label column
     */
    echo html_writer::tag(
        'td',
        get_string($name, 'minstandards'),
        ['class' => 'align-middle']
    );

    /*
     * Help icon column
     */
    echo html_writer::tag(
        'td',
        $OUTPUT->help_icon(
            $name,
            'minstandards'
        ),
        ['class' => 'text-center align-middle']
    );

    echo html_writer::end_tag('tr');
}





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

echo html_writer::start_tag('tbody');

render_check_row('interactivity', $checklist, $canedit, $OUTPUT);
render_check_row('flexibility', $checklist, $canedit, $OUTPUT);
render_check_row('collaboration', $checklist, $canedit, $OUTPUT);

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

echo $OUTPUT->footer();

