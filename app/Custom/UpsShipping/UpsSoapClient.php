<?php

namespace App\Custom\UpsShipping;

use \SoapClient;
use App\Custom\UpsShipping\Contacts\UpsSoapRequest;

class UpsSoapClient
{
	/**
	 * @var SoapClient
	 */
	protected $client;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var string
	 */
	protected $password;

	/**
	 * @var string
	 */
	protected $accessLicenseNumber;

	/**
	 * @var string
	 */
	protected $wsdlPath;

	/**
	 * UPS FREIGH RATES
	 */
	public function __construct(
		string $username, 
		string $password, 
		string $accessLicenseNumber,
		string $wsdlPath
	)
	{
		if (! file_exists($wsdlPath)) {
			throw new \Exception("Invalid path for wsdl");
		}

		$this->wsdlPath = $wsdlPath;
		$this->username = $username;
		$this->password = $password;
		$this->accessLicenseNumber = $accessLicenseNumber;
	}

	/**
	 * @return string
	 */
	public function getEndpointUrl()
	{
		return config('ups.sandbox', false)
			? 'https://wwwcie.ups.com/webservices/FreightRate'
			: 'https://onlinetools.ups.com/webservices/FreightRate';
	}

	/**
	 * Set SoapClient for this request
	 * 
	 * @return self
	 */
	protected function setClient()
	{
		$this->client = new SoapClient($this->wsdlPath , [
	        'soap_version' => 'SOAP_1_1',
	        'trace' => 1
	    ]);

	    $this->client->__setSoapHeaders(
	    	new \SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0','UPSSecurity',[
		    	'ServiceAccessToken' => [
		    		'AccessLicenseNumber' => $this->accessLicenseNumber
		    	],
		    	'UsernameToken' => [
		    		'Username' => $this->username,
		    		'Password' => $this->password,
		    	],
		    ])
	    );

		$this->client->__setLocation(
			$this->getEndpointUrl()
		);

	    return $this;
	}

	/**
	 * Get SoapClient instance
	 * 
	 * @return void
	 */
	public function getClient()
	{
		if (is_null($this->client)) {
			$this->setClient();
		}

		return $this->client;
	}

	/**
	 * @param  UpsSoapRequest $request
	 * @return mixed         
	 */
	public function makeRequest(UpsSoapRequest $request)
	{
		return $this->getClient()->__soapCall($request->getServiceEndpoint(), [
			$request->getRequest()
		]);
	}
}
