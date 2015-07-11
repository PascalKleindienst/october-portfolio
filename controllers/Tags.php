<?php namespace PKleindienst\Portfolio\Controllers;

use BackendMenu;
use Flash;
use Lang;
use Backend\Classes\Controller;
use PKleindienst\Portfolio\Models\Tag;

/**
 * Tags Back-end Controller
 */
class Tags extends Controller
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
     * @var array
     */
    public $requiredPermissions = [ 'pkleindienst.portfolio.access_tags' ];

    /**
     * @var \October\Rain\Flash\FlashBag
     */
    protected $flash;

    /**
     * @var \October\Rain\Translation\Translator
     */
    protected $lang;

    /**
     * @var \PKleindienst\Portfolio\Models\Tag
     */
    protected $tag;

    /**
     * @param \BackendMenu $backendMenu
     * @param \Flash $flash
     * @param \Lang $lang
     * @param \PKleindienst\Portfolio\Models\Tag $tag
     */
    public function __construct(BackendMenu $backendMenu, Flash $flash, Lang $lang, Tag $tag)
    {
        parent::__construct();

        $this->tag   = $tag;
        $this->flash = $flash::getFacadeRoot();
        $this->lang  = $lang::getFacadeRoot();

        $backendMenu::setContext('PKleindienst.Portfolio', 'portfolio', 'tags');
    }

    /**
     * Delete Tags
     * @return mixed
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
            $model = $this->tag;
            foreach ($checkedIds as $tagId) {
                if ((!$tag = $model::find($tagId))) {
                    continue;
                }

                $tag->delete();
            }

            $this->flash->success($this->lang->get('pkleindienst.portfolio::lang.portfolio.delete_success'));
        }

        return $this->listRefresh();
    }
}
