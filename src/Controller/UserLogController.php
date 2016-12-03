<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use CdiUser\Options\ModuleOptions;
use Zend\View\Model\ViewModel;

class UserLogController extends AbstractActionController {

    /** @var array */
    protected $options;
    protected $userMapper;

    /**
     * Description
     * 
     * @var \CdiDataGrid\Grid 
     */
    protected $grid;

    function getGrid() {
        return $this->grid;
    }

    function setGrid(\CdiDataGrid\Grid $grid) {
        $this->grid = $grid;
    }

    public function __construct(\CdiDataGrid\Grid $grid, ModuleOptions $options = null) {
        $this->grid = $grid;
        $this->options = $options;
    }

    public function logAction() {

        $this->grid->prepare();

        $this->grid->getFormFilters()->remove("password");

        $viewModel = new ViewModel(array('grid' => $this->grid));
        return $viewModel;
    }


}
