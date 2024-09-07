<?php

namespace Crm\BenefitsModule\Components\UserBenefitsListing;

use Crm\ApplicationModule\Models\Widget\BaseLazyWidget;

/**
 * This component fetches specific users benefits and renders them in a
 * data table. Used in user detail.
 *
 * @package Crm\BenefitsModule\Components
 */
class UserBenefitsListing extends BaseLazyWidget
{
    private $templateName = 'demo.latte';

    public function identifier()
    {
        return 'demowidget';
    }

    public function header()
    {
        return 'Benefits';
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . DIRECTORY_SEPARATOR . $this->templateName);
        $this->template->render();
    }
}