<?php

namespace Rick20\PPOB;

use GuzzleHttp\Client;
use Rick20\PPOB\Contracts\Product;
use Rick20\PPOB\Contracts\Provider;

abstract class AbstractProvider implements Provider
{
	protected $client;

	public function __construct(Client $client = null)
	{
		$this->client = $client ?: new Client();
	}

	protected function getCode(Product $product)
	{
		$type = (new \ReflectionClass($product))->getShortName();

		if (method_exists($this, $method = 'code' . $type)) {
			return $this->{$method}($product);
		}

		return $product->code();
	}

	protected function buildResult($response)
	{
		try {
			return json_decode($response->getBody()->getContents(), true);
		} catch (\Exception $error) {
			return $response->getBody()->getContents();
		}
	}
}
