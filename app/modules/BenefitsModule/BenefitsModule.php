<?php

namespace Crm\BenefitsModule;

use Crm\ApplicationModule\Models\Menu\MenuContainerInterface;
use Crm\ApplicationModule\Models\Menu\MenuItem;

class BenefitsModule extends \Crm\ApplicationModule\CrmModule
{
    public function registerAdminMenuItems(MenuContainerInterface $menuContainer): void
    {
        $mainMenu = new MenuItem(
            $this->translator->translate('Benefity'),
            ':Benefits:BenefitsAdmin:default',
            'fa fa-face-smile',
            500,
            true
        );

        $menuContainer->attachMenuItem($mainMenu);
    }

    public function registerRoutes(\Nette\Application\Routers\RouteList $router): void
    {
        $router->addRoute('/benefits', 'Benefits:BenefitsAdmin:default');
        $router->addRoute('/benefits/edit/<id>', 'Benefits:BenefitsAdmin:edit');
    }
}
