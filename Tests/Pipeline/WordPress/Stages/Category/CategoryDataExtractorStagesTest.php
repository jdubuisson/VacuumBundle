<?php

namespace Victoire\DevTools\VacuumBundle\Tests\Pipeline\WordPress\Stages\Category;

use Victoire\DevTools\VacuumBundle\Entity\WordPress\Blog;
use Victoire\DevTools\VacuumBundle\Pipeline\WordPress\Stages\Category\CategoryDataExtractorStages;
use Victoire\DevTools\VacuumBundle\Tests\Pipeline\WordPress\Stages\AbstractBaseStagesTests;

/**
 * Class CategoryDataExtractorStagesTest
 * @package Victoire\DevTools\VacuumBundle\Tests\Pipeline\WordPress\Stages\Category
 */
class CategoryDataExtractorStagesTest extends AbstractBaseStagesTests
{
    public function testPayloadIntegrity()
    {
        $stage = new CategoryDataExtractorStages();
        $params = [];
        $xml = file_get_contents('Tests/Resources/xml/category/category_data_extraction.xml');
        $payload = $this->getFreshPayload($params, $xml, new Blog());

        $payload = call_user_func($stage, $payload);
    }
}