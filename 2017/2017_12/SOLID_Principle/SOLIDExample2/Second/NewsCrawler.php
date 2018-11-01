<?php

namespace App\SOLIDExample2\Second;

use Illuminate\Database\Eloquent\Collection;


class NewsCrawler
{

    public $address, $language;
    public $newsType;

    function __construct($newsType, $address, $language)
    {
        $this->address = $address;
        $this->language = $language;
        $this->newsType = $newsType;
    }

    public function cookieChange()
    {
        // change cookie
    }

    public function getRequest(): string
    {
        // GET request
    }

    public function getContents($returnType): string
    {
        // getting contents

        switch ($returnType) {
            case 'html':
                // parse naver something
                break;
            case 'json':
                // parse naver something
                break;
            case 'xml':
                // parse naver something
                break;
        }
    }

    public function parse(): Collection
    {
        // parsing

        switch ($this->newsType) {
            case 'naver':
                // parse naver something
                break;
            case 'google':
                // parse naver something
                break;
            case 'nate':
                // parse naver something
                break;
        }
    }


}