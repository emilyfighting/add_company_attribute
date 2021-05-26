<?php
namespace Silk\CustomerDataIntegration\Model\Company;

use Magento\Company\Model\Company\DataProvider;
use Magento\Company\Api\Data\CompanyInterface;

class GetErpAttribute extends DataProvider{

    public function getCompanyResultData(CompanyInterface $company)
    {
        $result = [
            self::DATA_SCOPE_GENERAL => $this->getGeneralData($company),
            self::DATA_SCOPE_INFORMATION => $this->getInformationData($company),
            self::DATA_SCOPE_ADDRESS => $this->getAddressData($company),
            self::DATA_SCOPE_COMPANY_ADMIN => $this->getCompanyAdminData($company),
            self::DATA_SCOPE_SETTINGS => $this->getSettingsData($company),
            'erp_attributes' => $this->getErpAttributeData($company)
        ];
        $result['id'] = $company->getId();
        return $result;
    }

    public function getErpAttributeData(CompanyInterface $company)
    {
        return [
            'erp_account_code' => $company->getData('erp_account_code'),
            'customer_class_id1' => $company->getData('customer_class_id1'),
            'customer_class_id2' => $company->getData('customer_class_id2'),
            'customer_class_id3' => $company->getData('customer_class_id3'),
            'customer_class_id4' => $company->getData('customer_class_id4'),
            'customer_class_id5' => $company->getData('customer_class_id5'),
            'customer_web_enabled_flag' => filter_var(
                $company->getData('customer_web_enabled_flag'),
                FILTER_VALIDATE_BOOLEAN
            ),
            'customer_delete_flag' => filter_var(
                $company->getData('customer_delete_flag'),
                FILTER_VALIDATE_BOOLEAN
            ),
            'resale_certificate' => $company->getData('resale_certificate'),
            'invoice_type' => $company->getData('invoice_type'),

        ];
    }

}