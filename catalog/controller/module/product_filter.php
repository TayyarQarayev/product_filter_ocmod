<?php
namespace Opencart\Catalog\Controller\Extension\ProductFilter\Module;

class ProductFilter extends \Opencart\System\Engine\Controller
{
    public function index()
    {
        // $log = new \Opencart\System\Library\Log('countdown_debug.log');
        // $log->write(E_ALL);
        // ini_set('display_errors', 1);
        $this->load->language('extension/product_filter/module/product_filter');
        $this->load->model('extension/product_filter/module/product_filter');

        $data['products'] = [];

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['filter_name'])) {
            $filter_name = trim($this->request->post['filter_name']);

            if (!empty($filter_name)) {
                $products = $this->model_extension_product_filter_module_product_filter->getFilteredProducts($filter_name);

                foreach ($products as $product) {
                    $data['products'][] = [
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'href' => $this->url->link('product/product', 'language=' . $this->config->get('config_language') . '&product_id=' . (int) $product['product_id'], true)
                    ];
                }
            }
        }

        $this->response->setOutput(json_encode($data['products']));
        // dəyəri jsona çevirmədin deyə boş dəyər göndərirdi indi düzeldi

        // $log->write('Filtered Products: ' . json_encode($data['products']));
        return $this->load->view('extension/product_filter/module/product_filter', $data);
    }
}
