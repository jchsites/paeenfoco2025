<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/login/renderer.php');

class theme_adaptable_core_auth_renderer extends \core_auth\output\renderer {
    public function login(\core_auth\output\login $login) {
        $context = $login->export_for_template($this);
        return $this->render_from_template('theme_adaptable/core_auth/login', $context);
    }
}


