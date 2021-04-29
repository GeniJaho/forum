<?php

namespace Tests\Unit;


use App\Spam;
use Tests\TestCase;

class Test extends TestCase
{

    public function test_it_validates_spam()
    {
        $spam = new Spam;

        $this->assertFalse($spam->detect('Innocent reply here.'));
    }
}
