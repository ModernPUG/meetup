<?php

namespace App\SOLIDExample2\First;


use App\SOLIDExample2\News;
use App\SOLIDExample2\Third\NewsCrawlInterface;
use Carbon\Exceptions\InvalidDateException;
use Illuminate\Database\Eloquent\Collection;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Client;

class NateCrawler implements NewsCrawlInterface
{

    private $address = "www.nate.com";
    private $language = "ko";
    private $newsType = "xml";

    public function getRequest(): string
    {
        // GET request
        $this->address;
    }

    public function getContents(): string
    {
        // getting contents
        $this->newsType;
    }

    public function parse(): Collection
    {
        // parsing
    }

    public function save(): null
    {
        // save
    }

}