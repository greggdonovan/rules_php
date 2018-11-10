<?php

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase {
    public function testEmpty() {
        $this->assertEmpty([]);
    }
}