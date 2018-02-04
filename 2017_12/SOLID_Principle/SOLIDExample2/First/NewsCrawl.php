<?php

namespace App\SOLIDExample2\First;


use App\SOLIDExample2\News;
use Carbon\Exceptions\InvalidDateException;
use Illuminate\Database\Eloquent\Collection;
use Mockery\Exception;

class NewsCrawl
{

    private $newsSites = [
        [
            [
                "key" => "naver",
                "address" => "www.naver.com",
                "language" => "ko",
                "returnType" => "html"
            ]
        ],
        [
            [
                "key" => "google",
                "address" => "www.google.com",
                "language" => "en",
                "returnType" => "json"
            ]
        ],
        [
            [
                "key" => "nate",
                "address" => "www.nate.com",
                "language" => "ko",
                "returnType" => "xml"
            ]
        ]

    ];


    public function doCrawl()
    {

        foreach ($this->newsSites as $site) {

            // getRequest
            $response = $this->getRequest($site['address']);

            if ($response->getStatusCode() != 200) {

            } elseif ($response->getStatusCode() == 400) {
                throw new Exception();
            }



            // get contents
            $contents = $this->getContents($site['returnType']);

            if ($contents == null) {
                throw new Exception();
            } elseif ($contents == "") {
                throw new InvalidDateException("wrong", 400);
            }




            // parsing
            $parsedData = $this->parse($site, $contents);




            // save
            $parsedData->each(function (News $news) {
                $news->save();
            });


        }
    }


    private function getRequest($url): string
    {
        // GET request
    }

    private function getContents($returnType): string
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

    private function parse($newsType, $contents): Collection
    {
        // parsing

        switch ($newsType) {
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