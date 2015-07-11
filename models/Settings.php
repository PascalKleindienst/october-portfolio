<?php namespace PKleindienst\Portfolio\Models;

use Model;

/**
 * Settings Model
 * @package PKleindienst\Portfolio\Models
 */
class Settings extends Model
{
    public $implement = [ 'System.Behaviors.SettingsModel' ];

    // A unique code
    public $settingsCode = 'pkleindienst_portfolio_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
