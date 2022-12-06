<?php

namespace App\Custom\UpsShipping\Contacts;

interface UpsSoapRequest 
{
	public function getServiceEndpoint(): string;
	public function setRequest(): void;
	public function getRequest(): array;
}