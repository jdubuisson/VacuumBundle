<?php

namespace Victoire\DevTools\VacuumBundle\Tests\Pipeline\WordPress\Stages;

use Victoire\DevTools\VacuumBundle\Entity\WordPress\Blog;
use Victoire\DevTools\VacuumBundle\Pipeline\WordPress\Stages\Blog\BlogDataExtractorStages;

/**
 * Class BlogDataExtractorStages
 * @package Victoire\DevTools\VacuumBundle\Tests\Pipeline\WordPress\Stages
 */
class BlogDataExtractorStagesTest extends AbstractBaseStagesTests
{
    public function testPayloadIntegrity()
    {
        $stage = new BlogDataExtractorStages();
        $params = ["blog_name" => "Test Blog"];
        $xml = file_get_contents('Tests/Resources/xml/blog/blog_data_extraction.xml');
        $payload = $this->getFreshPayload($params, $xml, new Blog());

        $payload = call_user_func($stage, $payload);

        $expected = new Blog();
        $expected->setLocale("en");
        $expected->setTitle("Test Blog");
        $expected->setLink("http://www.testblog.com");
        $expected->setDescription("I test this blog");
        $expected->setPublicationDate(new \DateTime("Tue, 02 May 2017 13:56:23 +0000"));
        $expected->setBaseSiteUrl("http://www.testblog.com");
        $expected->setBaseBlogUrl("http://www.testblog.com");
        $expected->setId(1);
        $expected->setXmlTag("channel");

        $this->assertEquals($payload->getTmpBlog(), $expected);
    }
}