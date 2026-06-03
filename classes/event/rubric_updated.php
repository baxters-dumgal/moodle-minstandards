<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Rubric updated event.
 *
 * @package     mod_minstandards
 * @copyright   2026 Dumfries and Galloway College
 * @author      baxters@dumgal.ac.uk
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_minstandards\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Event triggered when rubric is updated.
 */
class rubric_updated extends \core\event\base {

    /**
     * Init.
     */
    protected function init() {

        $this->data['crud'] = 'u';

        $this->data['edulevel'] = self::LEVEL_TEACHING;

        $this->data['objecttable'] =
            'minstandards_rubric';
    }

    /**
     * Event name.
     *
     * @return string
     */
    public static function get_name() {

        return get_string(
            'eventrubricupdated',
            'minstandards'
        );
    }

    /**
     * Event description.
     *
     * @return string
     */
    public function get_description() {

        return "The user with id '{$this->userid}' " .
            "updated the rubric in the " .
            "Minimum Standards activity " .
            "with course module id '{$this->contextinstanceid}'.";
    }

    /**
     * URL for event.
     *
     * @return \moodle_url
     */
    public function get_url() {

        return new \moodle_url(
            '/mod/minstandards/view.php',
            [
                'id' => $this->contextinstanceid,
                'tab' => 'rubric'
            ]
        );
    }
}