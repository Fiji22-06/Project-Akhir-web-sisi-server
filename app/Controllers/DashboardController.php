<?php
class DashboardController extends Controller {
    public function index() {
        require_login(); // Ensure user is logged in
        $dashboardModel = $this->model('DashboardModel');
        $stats = $dashboardModel->getStats();

        $data = [
            'pageTitle' => 'Dashboard',
            'activePage' => 'dashboard',
            'stats' => $stats
        ];

        $this->view('dashboard/index', $data);
    }
}
