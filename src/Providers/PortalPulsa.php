<?php

namespace Rick20\PPOB\Providers;

use GuzzleHttp\Client;
use Rick20\PPOB\Products\Pulsa;
use Rick20\PPOB\AbstractProvider;
use Rick20\PPOB\Contracts\Product;

class PortalPulsa extends AbstractProvider
{
	protected $endpoint = 'https://portalpulsa.com/api/connect/';

	protected $prefix = [
		'pulsa' => [
			'telkomsel' => 'S',
			'indosat' => 'I',
			'xl' => 'X',
			'axis' => 'AX',
			'three' => 'T',
			'smartfren' => 'SM',
		]
	];

	private $userid;

	private $apikey;

	private $secret;


	public function __construct($username, $apikey, $secret, Client $client = null)
	{
		parent::__construct($client);

		$this->userid = $userid;
		$this->apikey = $apikey;
		$this->secret = $secret;
	}

	public function topup(Product $product, $refId)
	{
		return $this->send([
			'inquiry' => 'I',
			'code' => $this->getCode($product),
			'phone' => $product->subscriberId(),
			'trxid_api' => $refId,
			'no' => '1'
		]);
	}

	public function balance()
	{
		return $this->send([ 'inquiry' => 'S' ]);
	}

	public function status($refId)
	{
		return $this->send([
			'inquiry' => 'STATUS',
			'trxid_api' => $refId
		]);
	}

	public function codePulsa(Pulsa $pulsa)
	{
		return $this->prefix[ Pulsa::class ][ $pulsa->operator() ] . $nominal;
	}

	protected function send($data)
	{
		$response = $this->client->request('POST', $this->endpoint, [
			'headers' => [
				'portal-userid' => $this->userId,
				'portal-key' => $this->apikey,
				'portal-secret' => $this->secret,
			],
			'form_params' => $data
		]);

		return $response->getBody()->getContents();
	}
}
