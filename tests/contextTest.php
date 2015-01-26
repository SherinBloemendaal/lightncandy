<?php

require_once('src/lightncandy.php');
require_once('tests/helpers_for_test.php');

class contextTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider compileProvider
     */
    public function testUsedFeature($test)
    {
        LightnCandy::compile($test['template'], $test['options']);
        $context = LightnCandy::getContext();
        $this->assertEquals($test['expected'], $context['usedFeature']);
    }

    public function compileProvider()
    {
        $default = Array(
            'rootthis' => 0,
            'enc' => 0,
            'raw' => 0,
            'sec' => 0,
            'isec' => 0,
            'if' => 0,
            'else' => 0,
            'unless' => 0,
            'each' => 0,
            'this' => 0,
            'parent' => 0,
            'with' => 0,
            'comment' => 0,
            'partial' => 0,
            'dynpartial' => 0,
            'helper' => 0,
            'bhelper' => 0,
            'hbhelper' => 0,
            'delimiter' => 0,
        );

        $compileCases = Array(
             Array(
                 'template' => 'abc',
             ),

             Array(
                 'template' => 'abc{{def',
             ),

             Array(
                 'template' => 'abc{{def}}',
                 'expected' => Array(
                     'enc' => 1
                 ),
             ),

             Array(
                 'template' => 'abc{{{def}}}',
                 'expected' => Array(
                     'raw' => 1
                 ),
             ),

             Array(
                 'template' => 'abc{{&def}}',
                 'expected' => Array(
                     'raw' => 1
                 ),
             ),
        );

        return array_map(function($i) use ($default) {
            if (!isset($i['options'])) {
                $i['options'] = Array('flags' => 0);
            }
            if (!isset($i['options']['flags'])) {
                $i['options']['flags'] = 0;
            }
            $i['expected'] = array_merge($default, isset($i['expected']) ? $i['expected'] : array());
            return Array($i);
        }, $compileCases);
    }
}


?>
