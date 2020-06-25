<?php  
class MySoapClient extends SoapClient {
  public $sendRequest   = true;
  public $printRequest  = true;
  public $formatXML 	= true;
         
  public function __doRequest($request, $location, $action, $version, $one_way=0) {
  
	if ( $this->printRequest ) {
	  if ( !$this->formatXML ) {
		$out = $request;
	  }
	  else {
		$doc = new DOMDocument;
		$doc->preserveWhiteSpace = false;
		$doc->loadxml($request);
		$doc->formatOutput = true;
		$out = $doc->savexml();
	  }
	  echo $out;
	}
 
	if ( $this->sendRequest ) {
	  return parent::__doRequest($request, $location, $action, $version, $one_way);
	}
	else {
	  return '';
	}
  }
}

// "Soap 1.2 version (ws_http_Binding) settings";
$soap = new MySoapClient('http://netconnect.bluedart.com/ver1.7/Demo/ShippingAPI/Finder/ServiceFinderQuery.svc?wsdl',
							array(
								'trace' 				=> 1,  
								'style'					=> SOAP_DOCUMENT,
								'use'					=> SOAP_LITERAL,
								'soap_version'			=> SOAP_1_2
							));

$soap->__setLocation("http://netconnect.bluedart.com/ver1.7/Demo/ShippingAPI/Finder/ServiceFinderQuery.svc");

$soap->sendRequest 		= true;
$soap->printRequest 	= true;
$soap->formatXML 		= true; 

$actionHeader = new SoapHeader('http://www.w3.org/2005/08/addressing','Action','http://tempuri.org/IServiceFinderQuery/GetServicesforPincode',true);						

$soap->__setSoapHeaders($actionHeader);	
// end of Soap 1.2 version (WSHttpBinding)  settings
 
$params = array(
				 'pinCode' => '40000156',
				 'profile' => array(
								'Api_type' => 'S',
								'LicenceKey'=>'XXXXXXXXXXXXXXXXXXXXXXXXXXXX',
								'LoginID'=>'XXXXXXXXXX',
								'Version'=>'1.3')
		);             

$result = $soap->__soapCall('GetServicesforPincode',array($params));
print_r($result); 

print_r( $soap->__getLastRequest())."\n";
print_r($soap -> __getLastResponse());