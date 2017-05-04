<?php
namespace test\util;

use Httpful\Mime;
use Httpful\Request;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
    public function testLogin()
    {
        $login = Request::post('http://localhost/Login', http_build_query([]))
            ->expects(Mime::JSON)
            ->sendsType(Mime::FORM)
            ->send();
        $this->assertEquals(0, $login->body->error->code);
    }
}
