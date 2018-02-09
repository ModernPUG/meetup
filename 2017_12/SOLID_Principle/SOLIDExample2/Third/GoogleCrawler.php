<?php

namespace App\SOLIDExample2\First;


use App\SOLIDExample2\News;
use App\SOLIDExample2\Third\CookieChangableInterface;
use App\SOLIDExample2\Third\NewsCrawlInterface;
use Carbon\Exceptions\InvalidDateException;
use Illuminate\Database\Eloquent\Collection;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Client;

class GoogleCrawler implements NewsCrawlInterface, CookieChangableInterface
{

    private $address = "www.google.com";
    private $language = "en";
    private $newsType = "json";


    public function cookieChange()
    {
        // change cookie
        $this->language;
    }

    public function getRequest(): string
    {
        $this->cookieChange();
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