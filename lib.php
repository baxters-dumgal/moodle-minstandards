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

defined('MOODLE_INTERNAL') || die();

/**
 * Create a new Minimum Standards activity instance.
 */
function minstandards_add_instance($data, $mform = null) {

    global $DB;

    $data->timecreated = time();
    $data->timemodified = time();

    return $DB->insert_record('minstandards', $data);
}

/**
 * Update an existing Minimum Standards activity instance.
 */
function minstandards_update_instance($data, $mform = null) {

    global $DB;

    $data->id = $data->instance;
    $data->timemodified = time();

    return $DB->update_record('minstandards', $data);
}

/**
 * Delete a Minimum Standards activity instance.
 */
function minstandards_delete_instance($id) {

    global $DB;

    if (!$minstandards = $DB->get_record('minstandards', ['id' => $id])) {
        return false;
    }

    /*
     * Delete checklist records
     */
    $DB->delete_records(
        'minstandards_checklist',
        ['minstandardsid' => $minstandards->id]
    );

    /*
     * Delete rubric records
     */
    $DB->delete_records(
        'minstandards_rubric',
        ['minstandardsid' => $minstandards->id]
    );

    /*
     * Delete activity
     */
    $DB->delete_records(
        'minstandards',
        ['id' => $minstandards->id]
    );

    return true;
}





function minstandards_cm_info_view(cm_info $cm) {

    global $DB;

    /*
     * Get checklist
     */
    $checklist = $DB->get_record(
        'minstandards_checklist',
        ['minstandardsid' => $cm->instance]
    );
    if (!$checklist) {
        return;
    }    

    $rubric = $DB->get_record( 'minstandards_rubric', ['minstandardsid' => $cm->instance] );
    if (!$rubric) {
        return;
    }  



    /*
     * Calculate essential score
     */
    $essential = 0;

    $essentialfields = [
        'clearstructure',
        'moduledescription',
        'staffcontact',
        'accessibility',
        'communication',
        'resources',
        'assessment',
        'feedback',
        'uptodatecontent',
        'expectations'
    ];

    foreach ($essentialfields as $field) {

        if (!empty($checklist->$field)) {
            $essential++;
        }
    }

    /*
     * Calculate desirable score
     */
    $desirable = 0;

    $desirablefields = [
        'interactivity',
        'flexibility',
        'collaboration'
    ];

    foreach ($desirablefields as $field) {

        if (!empty($checklist->$field)) {
            $desirable++;
        }
    }


    /*
     * Calculate Rubric Score
     */

    $rubricscore = $rubric ? $rubric->totalscore : 0;
    
    /*
     * Build display
     */



/*
|--------------------------------------------------------------------------
| Essential colour
|--------------------------------------------------------------------------
*/

if ($essential >= 9) {

    $essentialclass = 'bg-success';

} else if ($essential >= 6) {

    $essentialclass = 'bg-warning text-dark';

} else {

    $essentialclass = 'bg-danger';
}

/*
|--------------------------------------------------------------------------
| Desirable colour
|--------------------------------------------------------------------------
*/

if ($desirable >= 3) {

    $desirableclass = 'bg-success';

} else if ($desirable >= 1) {

    $desirableclass = 'bg-warning text-dark';

} else {

    $desirableclass = 'bg-secondary';
}

/*
|--------------------------------------------------------------------------
| Rubric colour
|--------------------------------------------------------------------------
*/
if ($rubricscore >= 20) {

    $rubricclass = 'bg-success';

} else if ($rubricscore >= 10) {

    $rubricclass = 'bg-warning text-dark';

} else {

    $rubricclass = 'bg-secondary';
}


/*
|--------------------------------------------------------------------------
| Build badges
|--------------------------------------------------------------------------
*/

$essentialbadge = html_writer::tag(
    'span',
    "Essential: {$essential}/10",
    [
        'class' => "badge {$essentialclass} me-2"
    ]
);

$desirablebadge = html_writer::tag(
    'span',
    "Desirable: {$desirable}/3",
    [
        'class' => "badge {$desirableclass} me-2"
    ]
);

$rubricbadge = html_writer::tag(
    'span',
    "Rubric: {$rubricscore}/27",
    [
        'class' => "badge {$rubricclass}"
    ]
);

/*
|--------------------------------------------------------------------------
| Final content
|--------------------------------------------------------------------------
*/

$context = context_module::instance(
    $cm->id
);

if (has_capability(
    'mod/minstandards:editrubric',
    $context
)) {

    $content = html_writer::div(
        $essentialbadge .
        $desirablebadge .
        $rubricbadge,
        'mt-1'
    );

    $cm->set_after_link($content);
}


}


function minstandards_render_check_row(
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
    |--------------------------------------------------------------------------
    | Label + help icon
    |--------------------------------------------------------------------------
    */

    $label =
        get_string($name, 'minstandards') .
        ' ' .
        $OUTPUT->help_icon(
            $name,
            'minstandards'
        );

    echo html_writer::tag(
        'td',
        $label,
        ['class' => 'align-middle fw-medium']
    );


    echo html_writer::end_tag('tr');
}



/**
 * Render rubric row.
 */
function minstandards_render_rubric_row( $name, $rubric, $canedit, $OUTPUT ){

    echo html_writer::start_tag('tr');

    /*
    |--------------------------------------------------------------------------
    | Label + help icon
    |--------------------------------------------------------------------------
    */

    $label = get_string($name, 'minstandards') . ' ' . $OUTPUT->help_icon( $name, 'minstandards' );

    echo html_writer::tag(
        'td',
        $label,
        ['class' => 'align-middle fw-medium pe-3']
    );

    /*
     * Scores 0-3
     */
    for ($i = 0; $i <= 3; $i++) {


        $attributes = [
            'type' => 'radio',
            'name' => $name,
            'value' => $i,
            'class' => 'form-check-input'
        ];

        if ((int)$rubric->$name === $i) {
            $attributes['checked'] = 'checked';
        }

        if (!$canedit) {
            $attributes['disabled'] = 'disabled';
        }

        $radio = html_writer::empty_tag(
            'input',
            $attributes
        );

        echo html_writer::tag( 'td', html_writer::div( $radio, 'd-flex justify-content-center' ), ['class' => 'align-middle'] );
    }

    echo html_writer::end_tag('tr');
}

/**
 * Render guidance table row.
 *
 * @param string $name
 * @return void
 */
function minstandards_render_guidance_row($name) {

    echo html_writer::tag(
        'tr',

        html_writer::tag(
            'td',
            get_string($name, 'minstandards')
        ) .

        html_writer::tag(
            'td',
            get_string(
                $name . '_help',
                'minstandards'
            )
        ) .

        html_writer::tag(
            'td',
            get_string(
                $name . '_help_example',
                'minstandards'
            )
        )
    );
}


/**
 * Render rubric guidance row.
 *
 * @param string $name
 * @return void
 */
function minstandards_render_rubric_guidance_row(
    $name
) {

    echo html_writer::tag(
        'tr',

        html_writer::tag(
            'td',
            get_string($name, 'minstandards'),
            ['class' => 'fw-medium']
        ) .

        html_writer::tag(
            'td',
            get_string(
                $name . '_help',
                'minstandards'
            )
        ) .

        html_writer::tag(
            'td',
            get_string(
                $name . '_rubric_example',
                'minstandards'
            )
        )
    );
}



/**
 * Render rubric score guidance row.
 *
 * @param string $name
 * @return void
 */
function minstandards_render_rubric_score_row(
    $name
) {

    echo html_writer::tag(
        'tr',

        html_writer::tag(
            'td',
            get_string($name, 'minstandards'),
            ['class' => 'fw-medium']
        ) .

        html_writer::tag(
            'td',
            get_string(
                $name . '_help',
                'minstandards'
            )
        ) .        

        html_writer::tag(
            'td',
            get_string(
                $name . '_score0',
                'minstandards'
            )
        ) .

        html_writer::tag(
            'td',
            get_string(
                $name . '_score1',
                'minstandards'
            )
        ) .

        html_writer::tag(
            'td',
            get_string(
                $name . '_score2',
                'minstandards'
            )
        ) .

        html_writer::tag(
            'td',
            get_string(
                $name . '_score3',
                'minstandards'
            )
        )
    );
}

