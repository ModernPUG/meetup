<?php
/**
 * Created by PhpStorm.
 * User: ost
 * Date: 2017. 12. 6.
 * Time: AM 12:56
 */

namespace App\SOLIDExample2\Third;


use Illuminate\Database\Eloquent\Collection;

interface NewsCrawlInterface
{
    /**
     * @return string
     */
    public function getRequest(): string;

    /**
     * @param $returnType
     * @return string
     */
    public function getContents(): string;

    /**
     * @return Collection
     */
    public function parse(): Collection;

    /**
     * @return null
     */
    public function save(): null;
}