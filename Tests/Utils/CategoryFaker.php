<?php

namespace Victoire\DevTools\VacuumBundle\Tests\Utils;

use Victoire\DevTools\VacuumBundle\Entity\WordPress\Blog;
use Victoire\DevTools\VacuumBundle\Entity\WordPress\Category;

/**
 * Class CategoryFaker.
 */
class CategoryFaker
{
    /**
     * Add x categories to a blog.
     *
     * @param $nb
     * @param Blog $tmpBlog
     */
    public function generateWPCategories($nb, Blog $tmpBlog)
    {
        for ($ii = 1; $ii < $nb + 1; $ii++) {
            $category = new Category();
            $category->setCategoryName('Category Test '.$ii);
            $category->setCategoryNicename('category-test-'.$ii);
            $category->setCategoryParent(0);
            $category->setId($ii);
            $category->setXmlTag('category');
            $tmpBlog->addCategory($category);
        }
    }

    /**
     * Add x Victoire category to a Victoire Blog.
     *
     * @param $nb
     * @param \Victoire\Bundle\BlogBundle\Entity\Blog $vicBlog
     */
    public function generateVictoireCategory($nb, \Victoire\Bundle\BlogBundle\Entity\Blog $vicBlog)
    {
        for ($ii = 1; $ii < $nb + 1; $ii++) {
            $category = new \Victoire\Bundle\BlogBundle\Entity\Category();
            $category->setTitle('Category Test '.$ii);
            $category->setSlug('category-test-'.$ii);
            $vicBlog->addCategorie($category);
        }
    }
}