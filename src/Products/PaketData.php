<?php

namespace Rick20\PPOB\Products;

use Rick20\PPOB\PulsaTrait;

class PaketData extends GenericProduct
{
	use PulsaTrait;
	
	protected $nominal;

	public function __construct($phone, $nominal)
	{
		parent::__construct($phone, $phone);
		
		$this->nominal = $nominal;
	}

	public function phone()
	{
		return $this->phone;
	}

	public function nominal()
	{
		return $this->nominal;
	}

	public function operator()
	{
		return $this->toMobileOperator($this->subscriberId);
	}
}
