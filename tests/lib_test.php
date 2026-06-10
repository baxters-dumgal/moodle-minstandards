<?php
// This file is part of Moodle - http://moodle.org/

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/mod/minstandards/lib.php');

/**
 * PHPUnit tests for mod_minstandards.
 *
 * @package    mod_minstandards
 * @category   test
 * @copyright  2026
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class mod_minstandards_lib_test extends advanced_testcase {

    /**
     * Test a perfect rubric score.
     */
    public function test_calculate_rubric_score_maximum(): void {

        $rubric = (object)[
            'welcomeinfo' => 3,
            'grammar' => 3,
            'presentation' => 3,
            'learningresources' => 3,
            'completion' => 3,
            'assessment_rubric' => 3,
            'accessibility_rubric' => 3,
            'digitaltools' => 3,
            'multimedia' => 3,
        ];

        $this->assertEquals(
            27,
            minstandards_calculate_rubric_score($rubric)
        );
    }

    /**
     * Test a zero rubric score.
     */
    public function test_calculate_rubric_score_zero(): void {

        $rubric = (object)[
            'welcomeinfo' => 0,
            'grammar' => 0,
            'presentation' => 0,
            'learningresources' => 0,
            'completion' => 0,
            'assessment_rubric' => 0,
            'accessibility_rubric' => 0,
            'digitaltools' => 0,
            'multimedia' => 0,
        ];

        $this->assertEquals(
            0,
            minstandards_calculate_rubric_score($rubric)
        );
    }

    /**
     * Test a mixed rubric score.
     */
    public function test_calculate_rubric_score_mixed(): void {

        $rubric = (object)[
            'welcomeinfo' => 3,
            'grammar' => 2,
            'presentation' => 1,
            'learningresources' => 0,
            'completion' => 3,
            'assessment_rubric' => 2,
            'accessibility_rubric' => 1,
            'digitaltools' => 0,
            'multimedia' => 3,
        ];

        $this->assertEquals(
            15,
            minstandards_calculate_rubric_score($rubric)
        );
    }
}

