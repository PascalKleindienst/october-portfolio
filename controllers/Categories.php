<?php namespace PKleindienst\Portfolio\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

class Categories extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [ 'pkleindienst.portfolio.access_categories' ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('PKleindienst.Portfolio', 'portfolio', 'categories');
    }
}