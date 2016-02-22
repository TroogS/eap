<?php
/**
 * Default settings class
 *
 * @author Andre Beging
 */

class Settings {
    const maintenance = "asd";

    /**
     * Returns a constant if defined
     * @param  string $settingName Constant name
     * @return mixed              Constant value
     */
    public static function getDefault($settingName) {
        if (defined("self::{$settingName}")) {
            return constant("self::{$settingName}");
        }
        return false;
    }

    public function __construct() {
        throw new Exception("Can't get an instance of Settings Class");
    }

}
?>