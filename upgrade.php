<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Upgrade script for mod_minstandards.
 *
 * @package     mod_minstandards
 * @copyright   2026 Dumfries and Galloway College
 * @author      baxters@dumgal.ac.uk
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade function.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_minstandards_upgrade($oldversion) {

    global $DB;

    $dbman = $DB->get_manager();

    /*
    |--------------------------------------------------------------------------
    | Rename rubric fields
    |--------------------------------------------------------------------------
    */



    if ($oldversion < 2026060209) {

        $table = new xmldb_table(
            'minstandards_rubric'
        );

        /*
        |--------------------------------------------------------------------------
        | Rename assessment
        |--------------------------------------------------------------------------
        */

        $oldfield = new xmldb_field( 'assessment' );

        $newfield = new xmldb_field( 
            'assessment_rubric', 
            XMLDB_TYPE_INTEGER, 
            '1', 
            null, 
            XMLDB_NOTNULL, 
            null, 
            '0' 
        );

        if ($dbman->field_exists($table, $oldfield)) { 
            $dbman->rename_field( $table, $oldfield, $newfield ); 
        }

        /*
        |--------------------------------------------------------------------------
        | Rename accessibility -> accessibility_rubric
        |--------------------------------------------------------------------------
        */

        $oldfield = new xmldb_field(
            'accessibility'
        );

        $newfield = new xmldb_field(
            'accessibility_rubric',
            XMLDB_TYPE_INTEGER,
            '1',
            null,
            XMLDB_NOTNULL,
            null,
            '0'
        );

        if ($dbman->field_exists($table, $oldfield)) {

            $dbman->rename_field(
                $table,
                $oldfield,
                $newfield
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Savepoint
        |--------------------------------------------------------------------------
        */

        upgrade_mod_savepoint(
            true,
            2026060209,
            'minstandards'
        );
    }


    return true;
}