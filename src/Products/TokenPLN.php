<?php

namespace Rick20\PPOB\Products;

class TokenPLN extends GenericProduct
{
	protected $nominal;

	public function __construct($subscriberId, $phone, $nominal)
	{
		parent::__construct($subscriberId, $phone);
		
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
}
