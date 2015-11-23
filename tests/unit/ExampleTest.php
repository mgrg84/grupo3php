<?php

use common\models;

class ExampleTest extends \PHPUnit_Framework_TestCase
//class ExampleTest extends \Codeception\TestCase\Test
{

    private $categoria;

    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function testMe()
    {
        $categoria = new Categoria();
        $categoria->nombre="categoria";
        $categoria->save();

       /* $categoria = Categoria::create();
        $categoria->nombre = null;
        //$this->assertFalse($user->validate(['nombre']));
        $categoria->nombre = "categoria marianela";
        $this->assertFalse($user->validate(['nombre']));*/

    }

   

}
