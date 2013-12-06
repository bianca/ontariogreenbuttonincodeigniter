<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Greenbutton extends CI_Controller {

	/**
	 * Handling Green Button Stuff
	 */


    public function chooseCustodian() {
        // Grab
        $this->load->model("green_button");
        $data = array();
        $data['custodians'] = $this->green_button->fetchCustodians();
        $this->load->view("gb_chooseCustodian", $data);
    }


	public function auth() {
        $this->load->helper('url');
        $this->load->library('session');

        $this->load->spark('oauth2/0.4.0');

        $this->config->load('greenbutton', true);
        $provider = $this->oauth2->provider("Greenbutton", $this->config->item('client', 'greenbutton'));

        if ( ! $this->input->get('code') && ! $this->input->post('custodian'))
        {
            $this->chooseCustodian();

        }
        else if ( $this->input->post('custodian')) {

            $custodian = $this->input->post('custodian');
            $this->load->database();
            $this->db->where("name",$custodian);
            $results = $this->db->get("gb_custodians");
            $row = $results->result_array();
            $provider->setCustodian($custodian, $row[0]);
            $options = array(
                "redirect_uri" => $provider->redirect_uri . "?custodian=".$custodian
            );
            redirect($provider->authorize());
        }
        else
        {
            $custodian = $this->input->get('custodian');
            $this->load->database();
            $this->db->where("name",$custodian);
            $results = $this->db->get("gb_custodians");
            $row = $results->result_array();
            $provider->setCustodian($custodian, $row[0]);
            try
            {
                $opt =  array(
                    "redirect_uri" => base_url().$this->config->item('redirect_uri', 'greenbutton'),
                    "state" => $_GET["state"]
                );
                $token = $provider->access($_GET['code'],$opt);
                // Maybe you'd like to save the token somewhere now?

                $authorization = $provider->get_authorization($token);
                $this->load->model("green_button");
                $auth = $this->green_button->parseAuth($authorization);
                // Maybe you want to do something with auth now?

                $eui = $provider->get_info($token, mktime(0, 0, 0, date("m")  , date("d")-10, date("Y")), 86400);
                $data = $this->green_button->parseDoc($eui, "str");
                // Data! Do something with it!!!
            }

            catch (OAuth2_Exception $e)
            {
                show_error('That didnt work: '.$e);
            }

        }

	}

}