<?php

namespace Rick20\PPOB\Providers;

use Rick20\PPOB\AbstractProvider;
use Rick20\PPOB\Contracts\Product;
use Rick20\PPOB\Products\TokenPLN;

class Tripay extends AbstractProvider
{
	private $apikey;

	private $pin;

	public function __construct($apikey, $pin, Client $client = null)
	{
		parent::__construct($client);

		$this->apikey = $apikey;
		$this->pin = $pin;
	}

	public function topup(Product $product, $refId)
	{
		$data = [
			'inquiry' => 'I',
			'code' => $this->getCode($product),
			'phone' => $product->phone(),
			'pin' => $this->pin
		];

		if ($product instanceof TokenPLN) {
			$data['no_meter_pln'] = $product->subscriberId();
		}

		return $this->send(
			'https://tripay.co.id/api/v2/transaksi/pembelian', $data
		);
	}

	public function balance()
	{
		return $this->send('https://tripay.co.id/api/v2/ceksaldo/');
	}

	public function status($refId)
	{
		return $this->send(
			'https://tripay.co.id/api/v2/histori/transaksi/detail', 
			[ 'trxid' => $refId ]
		)
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
				'Authorization' => 'Bearer ' . $this->apikey
			],
			'form_params' => $data
		]);

		return $this->buildResult($response);
	}
}
