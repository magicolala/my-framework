<?php

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    /**
     * @return void
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testHello()
    {
        $name = 'Cédric';

        ob_start();
        include __DIR__ . '/../src/pages/hello.php';
        $content = ob_get_clean();

        $this->assertEquals('Hello Cédric', $content);
    }
}
