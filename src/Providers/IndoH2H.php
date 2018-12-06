<?php

namespace Rick20\PPOB\Providers;

use Rick20\PPOB\Products\Pulsa;
use Rick20\PPOB\AbstractProvider;
use Rick20\PPOB\Contracts\Product;
use Rick20\PPOB\Products\TokenPLN;

class IndoH2H extends AbstractProvider
{
	private $username;

	private $apikey;

	private $endpoints = [
		Pulsa::class => 'http://api.indoh2h.com/h2h/pulsa',
		TokenPLN::class => 'http://api.indoh2h.com/h2h/pln_prepaid',
	];

	public function __construct($username, $apikey, Client $client = null)
	{
		parent::__construct($client);

		$this->username = $username;
		$this->apikey = $apikey;
	}

	public function topup(Product $product, $refId)
	{
		$data = [
			'action' => 'purchase',
			'code' => $this->getCode($product),
			'number' => $product->subscriberId(),
			'trx_ref' => $refId
		];

		$endpoint = $product->subscriberId() == $product->phone() ? 
			$this->endpoints[Pulsa::class] : 
			$this->endpoints[TokenPLN::class];

		return $this->send($endpoint, $data);
	}

	public function balance()
	{
		return $this->send('http://api.indoh2h.com/h2h/account', [
			'action' => 'check_balance'
		]);
	}

	public function status($refId)
	{
		return $this->send(
			'http://api.indoh2h.com/h2h/transaction', [
				'action' => 'check_by_trx_ref',
				'trx_ref' => $refId
			]
		);
	}

	public function codeTokenPLN(TokenPLN $product)
	{
		return 'PLN' . ($product->nominal() / 1000);
	}

	protected function send($url, $data)
	{
		$response = $this->client->request('POST', $url, [
			'headers' => [
				'Accept' => 'application/json',
			],
			'form_params' => array_merge($data, [
				'username' => $this->username,
				'api_key' => $this->apikey
			])
		]);

		return $this->buildResult($response);
	}
}
