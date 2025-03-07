<?php
    namespace App\Controllers\admin;
    use App\Models\ResumeModel;
    use Framework\Auth;

    class DashboardController extends BaseController {
        private $resume;
        public function __construct() {
             $this->resume = new ResumeModel();
        }

        public function index() {
            $sumResumeByDay = $this->resume->getAllByDay();
            $sumResumeByMonth = $this->resume->getAllByMonth();
            $sumResumeByYear = $this->resume->getAllByYear();
            $sumResumePending = $this->resume->getAllPending();

            $sumResume = [
                'totalDay' => $sumResumeByDay['totalDay'],
                'totalMonth' => $sumResumeByMonth['totalMonth'],
                'totalYear' => $sumResumeByYear['totalYear'],
                'totalPending' => $sumResumePending['totalPending'],
            ];

            $resumesNew = $this->resume->getAllNew();

            return loadView('admin','dashboard/index', [
                'sumResume' => $sumResume,
                'newResumes' => $resumesNew,
            ]);
        }
    }