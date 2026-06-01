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

require_once($CFG->dirroot . '/course/moodleform_mod.php');

class mod_minstandards_mod_form extends moodleform_mod {

    public function definition() {

        $mform = $this->_form;

        /*
         * General
         */

        $mform->addElement(
            'text',
            'name',
            get_string('name'),
            ['size' => '64']
        );

        $mform->setType('name', PARAM_TEXT);

        $mform->addRule(
            'name',
            null,
            'required',
            null,
            'client'
        );

        /*
         * Intro
         */

        $this->standard_intro_elements();

        /*
         * Course module settings
         */

        $this->standard_coursemodule_elements();

        /*
         * Action buttons
         */

        $this->add_action_buttons();
    }
}
