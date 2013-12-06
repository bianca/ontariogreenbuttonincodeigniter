<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Greenbutton
 *
 * This model represents green button data:
 *
 * @package Greenbutton
 * @author  Bianca Sayan (http://www.biancasayan.com)
 */
class Green_button extends CI_Model
{

  public $commodity_types = array(
  	"0" => "Not Applicable",
  	"1" => "Electricity Metered Value",
  	"4" => "Air",
  	"7" => "NaturalGas",
  	"8" => "Propane",
  	"9" => "PotableWater",
  	"10" => "Steam",
  	"11" => "WasteWater",
  	"12" => "HeatingFluid",
  	"13" => "CoolingFluid"
  	);

  public $accumulation_behavior = array(
   	"0" => "Not Applicable",
  	"1" => "Bulk Quantity",
  	"3" => "Cumulative",
  	"4" => "DeltaData",
  	"6" => "Indicating",
  	"9" => "Summation",
  	"12" => "Instantaneous"
  	);

  public $data_qualifier = array(
   	"0" => "Not Applicable",
  	"2" => "Average",
  	"8" => "Maximum",
  	"9" => "Minimum",
  	"12" => "Normal"
  	);

    public $flow_direction = array(
   	"0" => "Not Applicable",
  	"1" => "Forward",
  	"19" => "Reverse"
  	);

  	public $kind = array(
   	"0" => "Not Applicable",
  	"3" => "Currency",
  	"4" => "Current",
  	"5" => "CurrentAngle",
  	"7" => "Date",
  	"8" => "Demand",
  	"12" => "Energy",
  	"15" => "Frequency",
  	"37" => "Power",
  	"38" => "PowerFactor",
  	"40" => "QuantityPower",
  	"54" => "Voltage",
  	"55" => "VoltageAngle",
  	"64" => "DistortionPowerFactor",
  	"155" => "VolumetricFlow"
  	);

  	public $phase_code = array(
	   	"0" => "Not Applicable",
	  	"129" => "AN",
	  	"128" => "A",
	  	"132" => "AB",
	  	"64" => "B/N",
	  	"32" => "C/N",
	  	"224" => "ABC",
	  	"66" => "BC",
	  	"40" => "CA",
	  	"512" => "S1",
	  	"256" => "S2",
	  	"768" => "S1S2",
	  	"513" => "S1N",
	  	"257" => "S2N",
	  	"769" => "S1S2N"
  	);

  	public $time_attribute = array(
	   	"0" => "Not Applicable",
	  	"1" => "10-minute",
	  	"2" => "15-minute",
	  	"4" => "24-hour",
	  	"5" => "30-minute",
	  	"7" => "60-minute",
	  	"11" => "Daily",
	  	"13" => "Monthly",
	  	"15" => "Present",
	  	"16" => "Previous",
	  	"24" => "Weekly",
	  	"32" => "ForTheSpecifiedPeriod",
	  	"79" => "Daily30minuteFixedBlock"
  	);



  public function fetchCustodians($update = false) {
  	if ($update == true) {
  		/*
  		// Uncomment this part and update $custodian_directory_url when greenbuttondata.org actually has one...
  		$custodian_directory_url = 'http://www.greenbuttondata.ca/.../custodiandirectory.xml';
		$xml = file_get_contents($custodian_directory_url);
		$xml = array();
    	$doc = new DOMDocument();
    	$doc->loadXML($xml);
  		$doc->save("/assets/data/custodiandirectory.xml");
  		
  		$xml = array();
    	$doc = new DOMDocument();
  		$doc->load("assets/data/custodiandirectory.xml");
  		$custodians = array();
  		foreach ($doc->getElementsByTagName( "data_custodians" )->item(0)->getElementsByTagName( "data_custodian" ) as $datum) {
  			$custodian_profile = $datum->getElementsByTagName( "profile" )->item(0)->nodeValue;
  			$custodian_name = $datum->getElementsByTagName( "name" )->item(0)->nodeValue;
  			$custodian_xml = file_get_contents($custodian_profile);
  			if ($custodian_xml != false) {
		    	$custodian_doc = new DOMDocument();
		    	$custodian_doc->loadXML($custodian_xml);
		    	$custodian_info = $custodian_doc->getElementsByTagName( "profile" )->item(0);
		    	$custodians[$custodian_name] = array(
	  			    "name" => $custodian_name,
	    			"profile" => $custodian_profile,
	    			"website" => $custodian_info->getElementsByTagName( "website" )->item(0)->nodeValue,
	 				"registration_url" => $custodian_info->getElementsByTagName( "registration_url" )->item(0)->nodeValue,
					"authorization_url" => $custodian_info->getElementsByTagName( "authorization_url" )->item(0)->nodeValue,
					"token_endpoint" => $custodian_info->getElementsByTagName( "token_endpoint" )->item(0)->nodeValue,
					"revoke_endpoint" => $custodian_info->getElementsByTagName( "revoke_endpoint" )->item(0)->nodeValue,
					"usage_endpoint" => $custodian_info->getElementsByTagName( "usage_endpoint" )->item(0)->nodeValue,
					"subscription_endpoint" => $custodian_info->getElementsByTagName( "subscription_endpoint" )->item(0)->nodeValue,
					"readservice_endpoint" => $custodian_info->getElementsByTagName( "readservice_endpoint" )->item(0)->nodeValue,
					"readauthorization_endpoint" => $custodian_info->getElementsByTagName( "readauthorization_endpoint" )->item(0)->nodeValue
	  			);
	  			$this->load->database();
	  			$this->db->where("name", $custodian_name);
  				$this->db->update("gb_custodians", $custodians[$custodian_name]);
	    	}
    	}
    	*/
  	}
	$this->load->database();
	$this->db->select('name');
	$r = $this->db->get("gb_custodians");
	if ($r->num_rows() > 0) {
		return $r->result_array();
	} else {
		return $this->fetchCustodians(true);
	}
 }

  public function parseAuth($xml) {
    $doc = new DOMDocument();
	$doc->loadXML($xml);
	$scope = explode(" ", $doc->getElementsByTagName( "scope" )->item(0)->nodeValue);
	$currentStatus = $doc->getElementsByTagName( "currentStatus" )->item(0)->nodeValue;
	$expiry = $doc->getElementsByTagName( "expiry" )->item(0)->nodeValue;
    $auth = array(
        "currentStatus" => $currentStatus,
        "expiry" => $expiry
        );
    foreach ($scope as $str) {
        if (strpos($str, "=") != false) {
            $this_str = explode("=", $str);
            $auth[$this_str[0]] = $this_str[1];
        }
    }
 	return $auth;
  }


  public function parseDoc($doc_name, $ds) {
    $doc = new DOMDocument();
    if ($ds == "str") {
    	$doc->loadXML($doc_name);
    } else {
    	$doc->load($doc_name);
    }

    $dataset = array();
    // Get the newest date
    foreach ($doc->getElementsByTagName( "entry" ) as $datum) {
    	$content = $datum->getElementsByTagName( "content" )->item(0);
    	$rv = $content->getElementsByTagName( "ReadingType" );
    	if ($rv->length != 0) {
	        $datetime = date("YmdH",intval($datum->getElementsByTagName( "published" )->item(0)->nodeValue));
	        $dataset[] = array(
	        	"datetime" => $datetime,
	        	"accumulationBehaviour" => $this->accumulation_behavior[$rv->item(0)->getElementsByTagName( "accumulationBehaviour" )->item(0)->nodeValue],
				"commodity" => $this->commodity_types[$rv->item(0)->getElementsByTagName( "commodity" )->item(0)->nodeValue],
				"currency" => intval($rv->item(0)->getElementsByTagName( "currency" )->item(0)->nodeValue),
				"dataQualifier" => $this->data_qualifier[$rv->item(0)->getElementsByTagName( "dataQualifier" )->item(0)->nodeValue],
				"flowDirection" => $this->flow_direction[$rv->item(0)->getElementsByTagName( "flowDirection" )->item(0)->nodeValue],
				"intervalLength" => intval($rv->item(0)->getElementsByTagName( "intervalLength" )->item(0)->nodeValue),
				"kind" => $this->kind[$rv->item(0)->getElementsByTagName( "kind" )->item(0)->nodeValue],
				"phase" => $this->phase_code[$rv->item(0)->getElementsByTagName( "phase" )->item(0)->nodeValue],
				"powerOfTenMultiplier" => intval($rv->item(0)->getElementsByTagName( "powerOfTenMultiplier" )->item(0)->nodeValue),
				"timeAttribute" => $this->time_attribute[$rv->item(0)->getElementsByTagName( "timeAttribute" )->item(0)->nodeValue],
				"uom" => intval($rv->item(0)->getElementsByTagName( "uom" )->item(0)->nodeValue)
	        );       
    	}
    }
    return $dataset;
 }

}