<?php

require_once 'AuthController.php';

class Admin_ReportController extends Admin_AuthController
{
    public function instituteDeviceAction() {
        $form = new Admin_Form_InstituteDevice();

        if ($this->_request->get('search') || $this->_request->get('export')) {
            // Get value
            $instituteId = $this->_request->getQuery('instituteId');
            $startDate = $this->_request->getQuery('startDate');

            // Populate form
            $form->populate(compact('instituteId', 'startDate'));

            // Do search here
            $mDevice = new Admin_Model_Device();

            $paginator = Zend_Paginator::factory($mDevice->searchByInstituteId($instituteId, $startDate));

            if (!$paginator->count()) {
                $this->view->data = $paginator;
            } else {
                $this->prepareData($paginator, $instituteId, $startDate);
            }
        }
        $this->view->form = $form;
    }

    private function prepareData($paginator, $instituteId, $startDate)
    {
        $mDevice = new Admin_Model_Device();
        $mCountry = new Admin_Model_Country();
        $mFactory = new Admin_Model_Factory();

        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(10);
        $currentPage = $this->_request->getParam('page',1);
        $paginator->setCurrentPageNumber($currentPage);


        foreach ($paginator as &$device) {
            $mDevice->addExternalData($device);
        }

        $this->view->data = $paginator;
        $this->view->factories = $mFactory->makeList($mFactory->index());
        $this->view->countries = $mCountry->makeList($mCountry->index());

        // For exporting
        if ($this->_request->get('export')) {
            $this->exportPdf($instituteId, $startDate);
        }
    }

    private function exportPdf($instituteId, $startDate)
    {
        $mInstitute = new Admin_Model_Institute();
        $this->view->institute = $mInstitute->show($instituteId);
        if ($startDate) {
            $this->view->startDate = explode('-', $startDate);
        }
        $html = $this->view->render('report/institute-device-export.phtml');

        $dompdf = new DOMPDF();
        $dompdf->load_html(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $dompdf->render();

        $outputFileName = 'export_' . time() . '.pdf';
        $outputFilePath = $this->getInvokeArg('bootstrap')->getOption('parameters')['exportPath'] . $outputFileName;
        file_put_contents($outputFilePath, $dompdf->output());

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $outputFileName . '"');
        readfile($outputFilePath);

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
}