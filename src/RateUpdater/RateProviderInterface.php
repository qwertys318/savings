<?php namespace App\RateUpdater;

interface RateProviderInterface
{
    public function request(array $params): string;
}
