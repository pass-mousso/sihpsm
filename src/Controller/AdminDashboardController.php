<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminDashboardController extends DefaultLayoutController
{
    #[Route('/', name: 'admin_sih_dashboard')]
    public function index(): Response
    {
        # Include vendors and javascript files for dashboard widgets
        $this->theme->addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return $this->render('admin/pages/dashboards/index.html.twig');
    }
}
