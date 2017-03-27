<?php

namespace Victoire\DevTools\VacuumBundle\Pipeline\WordPress\Stages\Blog;


use Victoire\DevTools\VacuumBundle\Pipeline\StageInterface;
use Victoire\DevTools\VacuumBundle\Utils\Xml\XmlDataFormater;

class BlogDataExtractorStages implements StageInterface
{
    public function __invoke($playload)
    {
        $xmlDataFormater = new XmlDataFormater();

        foreach ($playload->getRawData()->channel as $blog) {
            $playload->setTitle($xmlDataFormater->formatString('title', $blog));
            $playload->setLink($xmlDataFormater->formatString('link', $blog));
            $playload->setPublicationDate($xmlDataFormater->formatDate('pubDate', $blog));
            $playload->setDescription($xmlDataFormater->formatString('description', $blog));
            $playload->setLanguage($xmlDataFormater->formatString('language', $blog));
            $playload->setBaseSiteUrl($xmlDataFormater->formatString('base_site_url', $blog));
            $playload->setBaseBlogUrl($xmlDataFormater->formatString('base_blog_url', $blog));
        }
        unset($xmlDataFormater);
        return $playload;
    }
}