<?php 
class ControllerPaymentRavepay extends Controller 
{
	private $error = array();

	public function index()
	{
		$this->load->language('payment/ravepay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ravepay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
 
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_pay'] = $this->language->get('text_pay');
        $data['text_disable_payment'] = $this->language->get('text_disable_payment');
        
        $data['entry_live_secret'] = $this->language->get('entry_live_secret');
        $data['entry_live_public'] = $this->language->get('entry_live_public');
        $data['entry_test_secret'] = $this->language->get('entry_test_secret');
        $data['entry_test_public'] = $this->language->get('entry_test_public');
        $data['entry_test_country'] = $this->language->get('entry_test_country');
        $data['entry_test_currency'] = $this->language->get('entry_test_currency');
        
        $data['entry_live'] = $this->language->get('entry_live');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_approved_status'] = $this->language->get('entry_approved_status');
        $data['entry_declined_status'] = $this->language->get('entry_declined_status');
        $data['entry_error_status'] = $this->language->get('entry_error_status');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['help_total'] = $this->language->get('help_total');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['live_secret'])) {
			$data['error_live_secret_key'] = $this->error['live_secret'];
		} else {
			$data['error_live_secret_key'] = '';
		}

		if (isset($this->error['live_public'])) {
			$data['error_live_public_key'] = $this->error['live_public'];
		} else {
			$data['error_live_public_key'] = '';
		}

		if (isset($this->error['error_test_secret_key'])) {
			$data['error_test_secret_key'] = $this->error['error_test_secret_key'];
		} else {
			$data['error_test_secret_key'] = '';
		}

		if (isset($this->error['test_public'])) {
			$data['error_test_public_key'] = $this->error['test_public'];
		} else {
			$data['error_test_public_key'] = '';
		}


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_payment'),
        'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('heading_title'),
        'href' => $this->url->link('payment/ravepay', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('payment/ravepay', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');


        if (isset($this->request->post['ravepay_total'])) {
			$data['ravepay_total'] = $this->request->post['ravepay_total'];
		} else {
			$data['ravepay_total'] = $this->config->get('ravepay_total');
		}

		if (isset($this->request->post['ravepay_order_status_id'])) {
			$data['ravepay_order_status_id'] = $this->request->post['ravepay_order_status_id'];
		} else {
			$data['ravepay_order_status_id'] = $this->config->get('ravepay_order_status_id');
		}

		if (isset($this->request->post['ravepay_currency'])) {
			$data['ravepay_currency'] = $this->request->post['ravepay_currency'];
		} else {
			$data['ravepay_currency'] = $this->config->get('ravepay_currency');
		}

		if (isset($this->request->post['ravepay_country'])) {
			$data['ravepay_country'] = $this->request->post['ravepay_country'];
		} else {
			$data['ravepay_country'] = $this->config->get('ravepay_country');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['ravepay_geo_zone_id'])) {
			$data['ravepay_geo_zone_id'] = $this->request->post['ravepay_geo_zone_id'];
		} else {
			$data['ravepay_geo_zone_id'] = $this->config->get('ravepay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['ravepay_status'])) {
			$data['ravepay_status'] = $this->request->post['ravepay_status'];
		} else {
			$data['ravepay_status'] = $this->config->get('ravepay_status');
		}

		if (isset($this->request->post['ravepay_sort_order'])) {
			$data['ravepay_sort_order'] = $this->request->post['ravepay_sort_order'];
		} else {
			$data['ravepay_sort_order'] = $this->config->get('ravepay_sort_order');
		}

		if (isset($this->request->post['ravepay_live'])) {
			$data['ravepay_live'] = $this->request->post['ravepay_live'];
		} else {
			$data['ravepay_live'] = $this->config->get('ravepay_live');
		}

		if (isset($this->request->post['ravepay_test_secret_key'])) {
			$data['ravepay_test_secret_key'] = $this->request->post['ravepay_test_secret_key'];
		} else {
			$data['ravepay_test_secret_key'] = $this->config->get('ravepay_test_secret_key');
		}

		if (isset($this->request->post['ravepay_test_public_key'])) {
			$data['ravepay_test_public_key'] = $this->request->post['ravepay_test_public_key'];
		} else {
			$data['ravepay_test_public_key'] = $this->config->get('ravepay_test_public_key');
		}

		if (isset($this->request->post['ravepay_live_secret_key'])) {
			$data['ravepay_live_secret_key'] = $this->request->post['ravepay_live_secret_key'];
		} else {
			$data['ravepay_live_secret_key'] = $this->config->get('ravepay_live_secret_key');
		}

		if (isset($this->request->post['ravepay_live_public_key'])) {
			$data['ravepay_live_public_key'] = $this->request->post['ravepay_live_public_key'];
		} else {
			$data['ravepay_live_public_key'] = $this->config->get('ravepay_live_public_key');
		}


        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/ravepay', $data));
	}

	public function validate()
	{
		if (!$this->user->hasPermission('modify', 'payment/ravepay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if($this->request->post['ravepay_live'] == 1){
        	if (empty($this->request->post['ravepay_live_secret_key'])) {
			$this->error['live_secret'] = $this->language->get('error_live_secret_key');
			}

			if (empty($this->request->post['ravepay_live_public_key'])) {
				$this->error['live_public'] = $this->language->get('error_live_public_key');
			}
        }else{
        	if (empty($this->request->post['ravepay_test_secret_key'])) {
				$this->error['error_test_secret_key'] = $this->language->get('error_test_secret_key');
			}
			if (empty($this->request->post['ravepay_test_public_key'])) {
				$this->error['test_public'] = $this->language->get('error_test_public_key');
			}
        }

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}