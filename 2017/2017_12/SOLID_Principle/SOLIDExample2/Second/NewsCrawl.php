<?php

namespace App\SOLIDExample2\Second;


use App\SOLIDExample2\News;
use Illuminate\Database\Eloquent\Collection;

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

            $crawler = new NewsCrawler($site['key'], $site['address'], $site['language']);

            if ($site['key'] == 'google') {
                $crawler->cookieChange();
            }

            $crawler->getRequest();

            $crawler->getContents($site['returnType']);

            /** @var Collection $parsedData */
            $parsedData = $crawler->parse();


            $parsedData->each(function(News $parsedNews){
                $parsedNews->save();
            });
        }
    }


}