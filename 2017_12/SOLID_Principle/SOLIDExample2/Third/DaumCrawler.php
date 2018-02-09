<?php

namespace App\SOLIDExample2\First;


use App\SOLIDExample2\News;
use App\SOLIDExample2\Third\CookieChangableInterface;
use App\SOLIDExample2\Third\NewsCrawlInterface;
use Carbon\Exceptions\InvalidDateException;
use Illuminate\Database\Eloquent\Collection;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Client;

class DaumCrawler implements NewsCrawlInterface
{

    /**
     * @return string
     */
    public function getRequest(): string
    {
        // TODO: Implement getRequest() method.
    }

    /**
     * @param $returnType
     * @return string
     */
    public function getContents(): string
    {
        // TODO: Implement getContents() method.
    }

    /**
     * @return Collection
     */
    public function parse(): Collection
    {
        // TODO: Implement parse() method.
    }

    /**
     * @return null
     */
    public function save(): null
    {
        // TODO: Implement save() method.
    }
}