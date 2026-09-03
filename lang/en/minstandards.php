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

/*
|--------------------------------------------------------------------------
| Plugin
|--------------------------------------------------------------------------
*/

$string['pluginname'] = 'Minimum Standards';
$string['modulename'] = 'Minimum Standards';
$string['modulenameplural'] = 'Minimum Standards';
$string['pluginadministration'] = 'Minimum Standards Administration';

$string['minstandards:addinstance'] = 'Add an instance of Minimum Standards';
$string['minstandards:editchecklist'] = 'Edit minimum standards checklist';
$string['minstandards:editrubric'] = 'Edit self-reflection rubric';
$string['minstandards:view'] = 'View Minimum Standards activity';
$string['minstandards:viewrubric'] = 'View self-reflection rubric';
/*
|--------------------------------------------------------------------------
| Tabs
|--------------------------------------------------------------------------
*/

$string['standardsrubricheader'] = 'Minimum Standards Checklist / Self-Reflection Rubric';
$string['minimumstandards'] = 'Minimum Standards Checklist'; 
$string['selfreflectionrubric'] = 'Self-Reflection Rubric';

$string['guidancetab'] = 'Tutor Guidance';
$string['checklisttab'] = 'Minimum Standards Checklist';
$string['rubrictab'] = 'Self Reflection Rubric';

/*
|--------------------------------------------------------------------------
| Checklist Items
|--------------------------------------------------------------------------
*/

$string['checklistintro'] = 'Use the checklist to record essential and desirable course contents';

$string['clearstructure'] = 'Clear course structure';
$string['clearstructure_help'] =
'The online course is adequately signposted to allow students to navigate separate units or elements.';
$string['clearstructure_help_example'] =
    'Example: Weekly topic sections, consistent labels, clear navigation menus and logical sequencing of learning materials.';

$string['moduledescription'] = 'Module Description / Outline';
$string['moduledescription_help'] =
'Display core module details such as description, outcomes, and assessment strategies. A LearnNet activity (tabset) is available to help you with this.';
$string['moduledescription_help_example'] =
    'Example: A welcome area containing module aims, learning outcomes, assessment schedule and teaching staff information.';

$string['staffcontact'] = 'Staff Contact Details';
$string['staffcontact_help'] =
'Staff contact details, work hours, and suitable communication methods should be provided to students.';
$string['staffcontact_help_example'] =
    'Example: Lecturer email address, response times, office hours and preferred communication channels clearly displayed.';

$string['accessibility'] = 'Accessibility';
$string['accessibility_help'] =
'The course should be accessible to all students, including those with disabilities. Alternatively, a plan should be in place to address highlighted issues. Anthology Ally can assist with this.';
$string['accessibility_help_example'] =
    'Example: Use headings, captions, alternative text, accessible documents and review Ally accessibility indicators regularly.';

$string['communication'] = 'Clear and consistent communication';
$string['communication_help'] =
'The course should provide clear and consistent communication about course expectations, assignments, and assessments.';
$string['communication_help_example'] =
    'Example: Weekly announcements, assessment reminders and clear instructions for activities and deadlines.';

$string['resources'] = 'Access to resources';
$string['resources_help'] =
'The course should provide students with access to relevant readings, videos, and other resources to support their learning.';
$string['resources_help_example'] =
    'Example: Reading lists, embedded videos, downloadable lecture notes and links to external learning materials.';

$string['assessment'] = 'Assessment';
$string['assessment_help'] =
'The course should provide opportunities for formative and summative assessment, clear instructions and grading guidance, and information about plagiarism and academic integrity.';
$string['assessment_help_example'] =
    'Example: Moodle assignments with marking rubrics, submission guidance, assessment criteria and plagiarism information.';

$string['feedback'] = 'Feedback';
$string['feedback_help'] =
'The instructor should provide prompt and constructive feedback on assignments and assessments to help students understand their progress and areas for improvement.';
$string['feedback_help_example'] =
    'Example: Timely written feedback, audio feedback or whole-class feedback summaries provided after assessment submission.';

$string['uptodatecontent'] = 'Up-to-date content';
$string['uptodatecontent_help'] =
'The course should be kept up to date with relevant, current, and accurate information.';
$string['uptodatecontent_help_example'] =
    'Example: Current reading materials, updated hyperlinks, accurate dates and removal of outdated resources or announcements.';

$string['expectations'] = 'Clear expectations';
$string['expectations_help'] =
'The course should have clear expectations of student engagement, participation, and interaction.';
$string['expectations_help_example'] =
    'Example: Clear participation guidance, attendance expectations and estimated study time for activities and assessments.';

$string['interactivity'] = 'Interactivity';
$string['interactivity_help'] =
'The course should include interactive elements such as discussion forums, group projects, and quizzes to engage students and promote active learning.';
$string['interactivity_help_example'] =
    'Example: Discussion forums, quizzes, H5P activities, polls or collaborative classroom tasks to encourage engagement.';

$string['flexibility'] = 'Flexibility';
$string['flexibility_help'] =
'The course should accommodate diverse learning preferences and provide flexibility in how and when students complete activities.';
$string['flexibility_help_example'] =
    'Example: Recorded sessions, downloadable resources and opportunities for asynchronous participation where appropriate.';

$string['collaboration'] = 'Collaboration';
$string['collaboration_help'] =
'The course should foster collaboration among students through group projects and discussions.';
$string['collaboration_help_example'] =
    'Example: Group presentations, peer review activities, shared documents and collaborative discussion tasks.';

$string['checklistguidance'] = 'Checklist Guidance';
$string['checklistguidanceintro'] = 'This checklist has been designed to establish a minimal standard ' .
    'across the college in relation to our digital platforms ' . 
    'to ensure a consistent student experience. ' . 
    'The aim is to ensure that all students are provided a minimum standard ' . 
    'in relation to digital learning resources and platforms.';

/*
|--------------------------------------------------------------------------
| Rubric
|--------------------------------------------------------------------------
*/
$string['eventrubricupdated'] = 'Rubric updated';

$string['saverubric'] = 'Save rubric';
$string['element'] = 'Element';

$string['rubricintro'] = 'Use the reflective rubric to evaluate course quality and identify areas for future enhancement.';


$string['rubricguidance'] = 'Rubric Guidance';
$string['rubricguidanceintro'] = 'This rubric is presented as a reflective tool, to assist you in evaluating the content of individual online courses. You should aim to use a blank form for each individual course or unit you are appraising. ';


/*
|--------------------------------------------------------------------------
| Rubric Help
|--------------------------------------------------------------------------
*/
$string['welcomeinfo'] = 'Welcome Area / Course information';
$string['welcomeinfo_help'] = 
    'Course should contain a structured welcome area including: ' .
    'Welcome, About, Outcomes, Delivery Schedule, ' .
    'Assessment, and Course Contacts';
    
$string['welcomeinfo_score0'] =
    'No attempt has been made to welcome the online learner.';
$string['welcomeinfo_score1'] =
    'Some welcome information is provided, but is not structured in the agreed format.';
$string['welcomeinfo_score2'] =
    'The course contains a partially completed welcome area with at least 3 of the 6 welcome components included.';
$string['welcomeinfo_score3'] =
    'Course contains a fully realised welcome area with Welcome, About, Outcomes, Delivery Schedule, Assessment and Course Contacts.';

$string['grammar'] = 'Grammar / Language / Spelling';
$string['grammar_help'] =
    'Language, grammar and spelling should be ' .
    'consistent and correct throughout the course.';

$string['grammar_score0'] =
    'Poor grammar, punctuation or spelling throughout the course.';
$string['grammar_score1'] =
    'Some obvious grammatical or spelling errors are present in the course material.';
$string['grammar_score2'] =
    'Language, grammar and spelling are generally consistent throughout the course, however there are some inconsistencies.';
$string['grammar_score3'] =
    'Language, grammar and spelling are consistent and correct throughout the course.';

$string['presentation'] = 'Presentation / Styling';
$string['presentation_help'] =
    'Presentation should follow a consistent ' .
    'approach using appropriate layouts, colours ' .
    'and institutional templates where available.';

$string['presentation_score0'] =
    'Confusing layouts or non-intuitive graphics have been used. Poor colour choices may have been made.';
$string['presentation_score1'] =
    'Some uniformity in the appearance of the material. Little effort has been made to structure the course material.';
$string['presentation_score2'] =
    'The course is generally uniform in appearance, however some isolated elements are sub-optimal.';
$string['presentation_score3'] =
    'A consistent approach is taken to the presentation of materials. Colour schemes are consistent with college standards and templates where available.';

$string['learningresources'] = 'Learning Resources';
$string['learningresources_help'] =
    'Provide a good variety of learning resources, ' .
    'working links, supporting guidance and ' .
    'further reading where appropriate.';

$string['learningresources_score0'] =
    'No learning resources are placed in the course.';
$string['learningresources_score1'] =
    'Little to no learning resources have been posted.';
$string['learningresources_score2'] =
    'Learning resources have been posted, however their purpose may not be clear and some links may be broken.';
$string['learningresources_score3'] =
    'A good variety of learning resources, links and further readings are provided. Links are functional and supporting guidance is included.';

$string['completion'] = 'Course / Activity Completion';
$string['completion_help'] =
    'Activity completion should be enabled and ' .
    'used meaningfully on key milestone activities. ' .
    'Course completion should normally depend ' .
    'upon summative activities.';

$string['completion_score0'] =
    'No attempt has been made to implement activity completion.';
$string['completion_score1'] =
    'Activity completion has been activated but is not used optimally or targets inappropriate activities.';
$string['completion_score2'] =
    'Activity completion has been activated and used in a targeted way, however the criteria are not always optimal.';
$string['completion_score3'] =
    'Activity completion has been activated and correctly implemented on key milestone activities using appropriate criteria.';

$string['assessment_rubric'] = 'Assessment';    
$string['assessment_rubric_help'] =
    'Assessments should use appropriate Moodle ' .
    'tools and contain clear learner guidance, ' .
    'expectations and due dates.';

$string['assessment_rubric_score0'] =
    'No assessments have been placed in the online course.';
$string['assessment_rubric_score1'] =
    'Assessments have been added, however they lack detail or do not use appropriate tools.';
$string['assessment_rubric_score2'] =
    'Assessments use appropriate tools, however detailed instructions or due dates may be missing.';
$string['assessment_rubric_score3'] =
    'Assessments are correctly implemented using appropriate tools with learner guidance and clearly defined due dates.';    

$string['accessibility_rubric'] = 'Accessibility';
$string['accessibility_rubric_help'] =
    'Course materials should support learners ' .
    'with additional needs through accessible ' .
    'formats and alternative methods of access. ' .
    'Anthology Ally may be used to review accessibility.';

$string['accessibility_rubric_score0'] =
    'No attempt has been made to support learners with additional needs in this course.';
$string['accessibility_rubric_score1'] =
    'Some minimal effort has been made to accommodate learners with additional needs.';
$string['accessibility_rubric_score2'] =
    'Some elements of the course support learners with additional needs, however there are omissions.';
$string['accessibility_rubric_score3'] =
    'The course has been constructed to support learners with additional needs and provides accessible formats for course materials.';

$string['digitaltools'] = 'Use of digital tools';
$string['digitaltools_help'] =
    'Digital tools such as quizzes, choices, ' .
    'interactive activities and collaborative tools ' .
    'should enhance learning activities. ' .
    'The SAMR model may help guide implementation.';

$string['digitaltools_score0'] =
    'None of the available digital tools have been used to enhance the course.';
$string['digitaltools_score1'] =
    'Some digital tools have been used in a substitutive manner.';
$string['digitaltools_score2'] =
    'Some digital tools have been used with augmentation to existing learning activities.';
$string['digitaltools_score3'] =
    'A variety of digital tools such as quizzes, choices and interactive activities have been used to enhance learning through modification or redefinition of tasks.';


$string['multimedia'] = 'Use of multi-media elements';    
$string['multimedia_help'] =
    'Multi-media resources should include ' .
    'clear learner instructions, captions, ' .
    'transcriptions or textual alternatives ' .
    'where appropriate.';

$string['multimedia_score0'] =
    'No multi-media elements have been added to the course.';
$string['multimedia_score1'] =
    'Sparse multi-media elements have been added, however these may lack transcriptions or supporting information.';
$string['multimedia_score2'] =
    'Several multi-media resources have been added, however some learner instructions or transcriptions are missing.';
$string['multimedia_score3'] =
    'A variety of multi-media resources have been added with clear instructions and appropriate textual alternatives.';

/*
|--------------------------------------------------------------------------
| Rubric Score Labels
|--------------------------------------------------------------------------
*/

$string['score0'] = '0';
$string['score1'] = '1';
$string['score2'] = '2';
$string['score3'] = '3';

/*
|--------------------------------------------------------------------------
| Rubric Score Meanings
|--------------------------------------------------------------------------
*/

$string['score0desc'] = 'Absent or not evidenced'; 
$string['score1desc'] = 'Emerging practice'; 
$string['score2desc'] = 'Developing and mostly effective'; 
$string['score3desc'] = 'Established, consistent and effective';

/*
|--------------------------------------------------------------------------
| Rubric Totals
|--------------------------------------------------------------------------
*/

$string['totalscore'] = 'Total Score';
$string['rubricmaxscore'] = 'Marks out of 27';



/*
|--------------------------------------------------------------------------
| Misc
|--------------------------------------------------------------------------
*/

$string['essential'] = 'Essential';
$string['desirable'] = 'Desirable';
$string['notes'] = 'Notes';
$string['totalscore'] = 'Total Score';
$string['lastupdated'] = 'Last updated';
$string['savechecklist'] = 'Save checklist';
$string['eventchecklistupdated'] = 'Minimum Standards checklist updated';
