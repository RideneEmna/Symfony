<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Article;

class UtilTest extends TestCase
{
    public function testTitleLength()
    {
        $title = 'Notre Produit';
        $article = new Article($title);
        $article->setTitle($title);
        $this->assertGreaterThan(5, strlen($article->getTitle()));

        $this->assertTrue(true);
    }
    public function testTitleIsString()
    {
        $title = 'Sample Title';
        $article = new Article($title);
        $article->setTitle($title);
        $this->assertIsString($article->getTitle());
    }
    public function testTitleStartsWithUpperCase()
    {
        $title = 'Sample Title';
        $article = new Article($title);
        $article->setTitle($title);
        $this->assertRegExp('/^[A-Z]/', $article->getTitle());
    }
}
