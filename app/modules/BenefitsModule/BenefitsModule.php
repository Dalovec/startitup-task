<?php

namespace Crm\BenefitsModule;

use Contributte\Translation\Exceptions\InvalidArgument;
use Crm\ApplicationModule\Models\Menu\MenuContainerInterface;
use Crm\ApplicationModule\Models\Menu\MenuItem;
use Crm\ApplicationModule\Models\Widget\LazyWidgetManagerInterface;

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

    /**
     * Register frontend menu item
     *
     * @param MenuContainerInterface $menuContainer
     * @throws InvalidArgument
     */
    public function registerFrontendMenuItems(MenuContainerInterface $menuContainer): void
    {
        $mainMenu = new MenuItem(
            $this->translator->translate('Benefits'),
            ':Benefits:Benefits:default',
            'fa fa-face-smile',
            100,
            true
        );
        $menuContainer->attachMenuItem($mainMenu);
    }
    public function registerRoutes(\Nette\Application\Routers\RouteList $router): void
    {
        $router->addRoute('/benefits', 'Benefits:BenefitsAdmin:default');
        $router->addRoute('/benefits/edit/<id>', 'Benefits:BenefitsAdmin:edit');
        $router->addRoute('/benefits/new', 'Benefits:BenefitsAdmin:new');

        $router->addRoute('/benefits/my', 'Benefits:Benefits:default');
    }

    public function registerLazyWidgets(LazyWidgetManagerInterface $lazyWidgetManager)
    {
        $lazyWidgetManager->registerWidget(
            'admin.user.detail.bottom',
            \Crm\BenefitsModule\Components\UserBenefitsListing\UserBenefitsListing::class,
            300
        );
    }
}
