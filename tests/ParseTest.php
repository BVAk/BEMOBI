<?php

use PHPUnit\Framework\TestCase;

final class ParseTest extends TestCase
{

    public function testCanLinksUsedAsArray(): void
    {
        $this->assertIsArray(Parser::getBrokenImage('http://localhost/bemobi/index.html'));
    }

    public function testCanImgUsedAsArray(): void
    {
        $this->assertIsArray(Parser::getAllLinks('http://localhost/bemobi/index.html'));
    }
}
