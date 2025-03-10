<?php
namespace Opencart\Catalog\Model\Extension\ProductFilter\Module;

class ProductFilter extends \Opencart\System\Engine\Model
{
    public function getFilteredProducts(string $filter_name): array
    {
        $language_id = (int) $this->config->get('config_language_id');
        $filter_name = $this->db->escape(mb_strtolower($filter_name, 'UTF-8'));

        $sql = sprintf(
            "SELECT p.product_id, pd.name 
            FROM `oc_product` p 
            LEFT JOIN `oc_product_description` pd 
            ON (p.product_id = pd.product_id) 
            WHERE pd.language_id = '%d' 
            AND LCASE(pd.name) LIKE '%s%%' 
            ORDER BY pd.name ASC LIMIT 10",
            $language_id,
            $filter_name
        );

        $query = $this->db->query($sql);
        return $query->rows;
    }

}
