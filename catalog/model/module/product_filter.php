<?php
namespace Opencart\Catalog\Model\Extension\ProductFilter\Module;

class ProductFilter extends \Opencart\System\Engine\Model
{
    public function getFilteredProducts(string $filter_name): array
    {
        $sql = "SELECT p.product_id, pd.name 
                FROM `" . DB_PREFIX . "product` p 
                LEFT JOIN `" . DB_PREFIX . "product_description` pd 
                ON (p.product_id = pd.product_id) 
                WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";

        if (!empty($filter_name)) {
            $sql .= " AND LCASE(pd.name) LIKE '%" . $this->db->escape(oc_strtolower($filter_name)) . "%'";
        }

        $sql .= " ORDER BY pd.name ASC LIMIT 10";

        $query = $this->db->query($sql);
        return $query->rows;
    }
}
