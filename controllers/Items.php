<?php namespace PKleindienst\Portfolio\Controllers;

use BackendMenu;
use Flash;
use Lang;
use Backend\Classes\Controller;
use PKleindienst\Portfolio\Models\Item;

/**
 * Items Back-end Controller
 * @package PKleindienst\Portfolio\Controllers
 */
class Items extends Controller
{
    /**
     * @var array
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var string
     */
    public $bodyClass = 'compact-container';

    /**
     * @var array
     */
    public $requiredPermissions = [ 'pkleindienst.portfolio.access_items' ];

    /**
     * @var \October\Rain\Flash\FlashBag
     */
    protected $flash;

    /**
     * @var \October\Rain\Translation\Translator
     */
    protected $lang;

    /**
     * @var \PKleindienst\Portfolio\Models\Item
     */
    protected $item;

    /**
     * @param BackendMenu $backendMenu
     * @param Flash $flash
     * @param Lang $lang
     * @param Item $item
     */
    public function __construct(BackendMenu $backendMenu, Flash $flash, Lang $lang, Item $item)
    {
        parent::__construct();

        $this->item  = $item;
        $this->flash = $flash::getFacadeRoot();
        $this->lang  = $lang::getFacadeRoot();

        $backendMenu::setContext('PKleindienst.Portfolio', 'portfolio', 'items');

        $this->addJs('/plugins/pkleindienst/portfolio/assets/js/form.js');
    }

    /**
     * Delete Items
     * @return mixed
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
            $model = $this->item;
            foreach ($checkedIds as $itemId) {
                if ((!$item = $model::find($itemId))) {
                    continue;
                }

                $item->delete();
            }

            $this->flash->success($this->lang->get('pkleindienst.portfolio::lang.portfolio.delete_success'));
        }

        return $this->listRefresh();
    }
}
