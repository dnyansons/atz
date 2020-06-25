<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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