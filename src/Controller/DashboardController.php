<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Service\Menu\MenuACLService;
use App\Service\Menu\MenuService;
use App\Service\ThemeHelper;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends DefaultLayoutController
{
    public function __construct(
        ThemeHelper $theme,
        private MenuACLService $menuService
    )
    {
        parent::__construct($theme);
    }

    public function index(): Response
    {
        # Include vendors and javascript files for dashboard widgets
        $this->theme->addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

//        $menu = $this->menuService->getAccessibleMenus();
//        dd($menu);

        return $this->render('admin/pages/dashboards/index.html.twig', [
        ]);
    }
}