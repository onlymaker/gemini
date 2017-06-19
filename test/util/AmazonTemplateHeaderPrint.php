<?php
namespace test\util;

use helper\AmazonTemplate;
use PHPUnit\Framework\TestCase;

class AmazonTemplateHeaderPrint extends TestCase
{
    public function testPrintUSHeader()
    {
        $this->assertNull(AmazonTemplate::printHeader(__DIR__ . "/amazon_template_header/us.xls"));
    }

    public function testPrintUKHeader()
    {
        $this->assertNull(AmazonTemplate::printHeader(__DIR__ . "/amazon_template_header/uk.xls"));
    }

    public function testPrintDEHeader()
    {
        $this->assertNull(AmazonTemplate::printHeader(__DIR__ . "/amazon_template_header/de.xls"));
    }
}
