<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

    /**
     * Testing building.
     *
     * @test 
     */
    public function building()
    {
        $this->assertEquals(true, true);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/api');

        $this->assertEquals(
            "LaCMS API", $this->response->getContent()
        );
    }
}
