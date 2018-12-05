<?php

namespace Rick20\PPOB\Contracts;

interface Provider
{
    public function topup(Product $product, $refId);

    public function balance();

    public function status($refId);
}
