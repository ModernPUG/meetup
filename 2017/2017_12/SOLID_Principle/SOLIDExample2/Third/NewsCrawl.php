<?php

namespace App\SOLIDExample2\Third;


use App\SOLIDExample2\First\DaumCrawler;
use App\SOLIDExample2\First\GoogleCrawler;
use App\SOLIDExample2\First\NateCrawler;
use App\SOLIDExample2\First\NaverCrawler;

class NewsCrawl
{

    public function doCrawl()
    {
        $crawlerClasses = [];

        $crawlerClasses[] = new NaverCrawler();
        $crawlerClasses[] = new GoogleCrawler();
        $crawlerClasses[] = new NateCrawler();
        $crawlerClasses[] = new DaumCrawler();


        /** @var NewsCrawlInterface $site */
        foreach ($crawlerClasses as $site) {

            $site->getRequest();

            $site->getContents();

            $site->parse();

            $site->save();

        }
    }


}