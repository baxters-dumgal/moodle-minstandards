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

namespace mod_minstandards\event;

defined('MOODLE_INTERNAL') || die();

class checklist_updated extends \core\event\base {

    /**
     * Initialise event.
     */
    protected function init() {

        $this->data['crud'] = 'u';

        $this->data['edulevel'] = self::LEVEL_TEACHING;

        $this->data['objecttable'] = 'minstandards_checklist';
    }

    /**
     * Event name.
     */
    public static function get_name() {

        return get_string(
            'eventchecklistupdated',
            'minstandards'
        );
    }

    /**
     * Event description.
     */
    public function get_description() {

        return "User with id '{$this->userid}' updated " .
               "the Minimum Standards checklist " .
               "with id '{$this->objectid}'.";
    }

    /**
     * URL to relevant page.
     */
    public function get_url() {

        return new \moodle_url(
            '/mod/minstandards/view.php',
            [
                'id' => $this->contextinstanceid
            ]
        );
    }
}
