<?php
namespace Silk\CustomerDataIntegration\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Company\Api\CompanyRepositoryInterface;
use Magento\Company\Api\Data\CompanyInterfaceFactory;

class AfterCompanyErpAttributeSaveObserver implements ObserverInterface
{
    private $companyRepository;

    private $companyDataFactory;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        CompanyInterfaceFactory $companyDataFactory
    ) {
        $this->companyRepository = $companyRepository;
        $this->companyDataFactory = $companyDataFactory;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $params = $observer->getRequest()->getParams();
        if (!empty($params['erp_attributes'])) {
            $erpAttribute = $params['erp_attributes'];
            if($erpAttribute['customer_web_enabled_flag'] == "true"){
                 $customer_web_enabled_flag= 1;
            }else{
                $customer_web_enabled_flag = 0;
            }
            if($erpAttribute['customer_delete_flag'] == "true"){
                $customer_delete_flag = 1;
            }else{
                $customer_delete_flag = 0;
            }
            $company = $observer->getCompany();
            $company->setData('erp_account_code',$erpAttribute['erp_account_code']);
            $company->setData('customer_class_id1',$erpAttribute['customer_class_id1']);
            $company->setData('customer_class_id2',$erpAttribute['customer_class_id2']);
            $company->setData('customer_class_id3',$erpAttribute['customer_class_id3']);
            $company->setData('customer_class_id4',$erpAttribute['customer_class_id4']);
            $company->setData('customer_class_id5',$erpAttribute['customer_class_id5']);
            $company->setData('customer_web_enabled_flag',filter_var(
                $erpAttribute['customer_web_enabled_flag'],
                FILTER_VALIDATE_BOOLEAN
            ));
            $company->setData('customer_delete_flag',filter_var(
                $erpAttribute['customer_delete_flag'],
                FILTER_VALIDATE_BOOLEAN
            ));
            $company->setData('resale_certificate',$erpAttribute['resale_certificate']);
            $company->setData('invoice_type',$erpAttribute['invoice_type']);
            $this->companyRepository->save($company);
        }
    }
}