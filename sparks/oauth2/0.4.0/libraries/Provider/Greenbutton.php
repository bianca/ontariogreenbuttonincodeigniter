<?php
/**
 * OAuth GreenButton Provider
 *
 * Documents for implementing Ontario's Green Button API OAuth can be found at
 * <http://greenbuttondata.ca>.
 *
 *
 * @package    OAuth
 * @category   Provider
 * @author     Bianca Sayan
 */

class OAuth2_Provider_Greenbutton extends OAuth2_Provider {
        /**
         * @var  string  the method to use when requesting tokens
         */
        public $method = 'GET';
        public $access_method = 'POST';
        /**
         * @var  string  scope separator, most use "," but some like Google are spaces
         */
        public $scope_seperator = ' ';

        public $name = 'greenbutton';

        public $custodian = null;

        public $urls = array();    

        public function url_request_token()
        {
                return $this->urls["token_endpoint"];
        }

        public function url_authorize()
        {
                return $this->urls["authorization_url"];
        }

        public function url_access_token()
        {
                return $this->urls["token_endpoint"];
        }

        public function url_authorization_status()
        {
                return $this->urls["readauthorization_endpoint"];
        }

        public function url_usage_endpoint()
        {
                return $this->urls["usage_endpoint"];
        }

        public function setCustodian($custodian, $urls)
        {
                $this->urls = $urls;
                $this->custodian = $custodian;
        }

        public function access($code, $options = array())
        {

          $params = array(
            'client_id'   => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type'  => isset($options['grant_type']) ? $options['grant_type'] : 'authorization_code',
          );

          if (isset($options['state'])) {
            $params['state'] = $options['state'];
          }

          switch ($params['grant_type'])
          {
            case 'authorization_code':
              $params['code'] = $code;
              $params['redirect_uri'] = isset($options['redirect_uri']) ? $options['redirect_uri'] : $this->redirect_uri;
            break;

            case 'refresh_token':
              $params['refresh_token'] = $code;
            break;
          }

          $response = null; 
          $url = $this->url_access_token();

          switch ($this->access_method)
          {
            case 'GET':

              // Need to switch to Request library, but need to test it on one that works
              $url .= '?'.http_build_query($params);
              $response = file_get_contents($url);
              parse_str($response, $return);
            break;

            case 'POST':
              unset($params['client_id']); unset($params['client_secret']); unset($params['state']);
              $postdata = http_build_query($params);
              ob_start();
              $curl = curl_init();
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($curl, CURLOPT_URL, $url. "?".$postdata);
              curl_setopt($curl, CURLOPT_POST, true);
              curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
              curl_setopt($curl, CURLOPT_HEADER, false);
              curl_setopt($curl, CURLOPT_VERBOSE, true);
              curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/atom+xml','Authorization: Basic '.base64_encode($this->client_id.":".$this->client_secret)));
              curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
              curl_setopt($curl, CURLOPT_FAILONERROR, true);
              $result = curl_exec($curl);
              $debug_out = ob_get_contents();
              ob_end_clean();
              curl_close($curl);            
            break;

            default:
              throw new OutOfBoundsException("Method '{$this->method}' must be either GET or POST");
          }

          if ( ! empty($return['error']))
          {
            throw new OAuth2_Exception($return);
          }
          
          return OAuth2_Token::factory('access', json_decode($result, true));
        }

        public function get_authorization($token) {
                $url = $this->url_authorization_status();
                ob_start();
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_STDERR, $verbose);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/atom+xml','Authorization: Bearer '.(String)$token->access_token));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_FAILONERROR, true);
                $result = curl_exec($curl);
                $debug_out = ob_get_contents();
                ob_end_clean();
                return $result;
        }

        public function get_user_info(OAuth2_Token_Access $token)
        {
                return $this->get_authorization($token);
        }

        public function get_info(OAuth2_Token_Access $token, $start_date, $duration)
        {
                $url = $this->url_usage_endpoint()."?".http_build_query(array(
                  'start' => $start_date,
                  'duration' => $duration
                ));
                ob_start();
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.(String)$token->access_token));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_FAILONERROR, true);
                $result = curl_exec($curl);
                $debug_out = ob_get_contents();
                ob_end_clean();
                curl_close($curl);
                return $result;
        }

} // End Provider_Tumblr