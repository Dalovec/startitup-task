<?php

namespace Crm\BenefitsModule\Components\UserBenefitsListing;

use Crm\ApplicationModule\Models\Widget\BaseLazyWidget;
use Crm\ApplicationModule\Models\Widget\LazyWidgetManager;
use Crm\BenefitsModule\Repositories\BenefitsRepository;
use Crm\BenefitsModule\Repositories\UserBenefitsRepository;

/**
 * This component fetches specific users benefits and renders them in a
 * data table. Used in user detail.
 *
 * @package Crm\BenefitsModule\Components
 */
class UserBenefitsListing extends BaseLazyWidget
{
    private $templateName = 'demo.latte';
    private $benefitsRepository;
    private $userBenefitsRepository;
    private $lazyWidgetManager;
    public function __construct(
        LazyWidgetManager $lazyWidgetManager,
        BenefitsRepository $benefitsRepository,
        UserBenefitsRepository $userBenefitsRepository,
    ){
        parent::__construct($lazyWidgetManager);
        $this->lazyWidgetManager = $lazyWidgetManager;
        $this->benefitsRepository = $benefitsRepository;
        $this->userBenefitsRepository = $userBenefitsRepository;
    }
    public function identifier()
    {
        return 'demowidget';
    }

    public function header($id = '')
    {
        return 'Benefits';
    }

    public function render($id)
    {
        $this->template->setFile(__DIR__ . DIRECTORY_SEPARATOR . $this->templateName);
        if ($this->userBenefitsRepository->isClaimed($id)) {
            $this->template->benefit = $this->benefitsRepository->find($this->userBenefitsRepository->isClaimed($id));
        }
        $this->template->userId = $id;
        $this->template->render();
    }

    public function handleUnclaim($id)
    {
        $this->userBenefitsRepository->resetUser($id);
    }
}