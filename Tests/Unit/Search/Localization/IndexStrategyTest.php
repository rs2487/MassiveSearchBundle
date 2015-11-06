<?php

/*
 * This file is part of the MassiveSearchBundle
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Massive\MassiveSearchBundle\Tests\Unit\Search;

use Massive\Bundle\SearchBundle\Search\Localization\IndexStrategy;

class IndexStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function provideLocalizeIndexName()
    {
        return [
            ['hello', 'fr', 'hello-fr-i18n'],
            ['hello', null, 'hello'],
            ['', 'fr', '-fr-i18n'],
        ];
    }

    /**
     * @dataProvider provideLocalizeIndexName
     */
    public function testLocalizeIndexName($indexName, $locale, $expected)
    {
        $strategy = new IndexStrategy();
        $result = $strategy->localizeIndexName($indexName, $locale);
        $this->assertEquals($expected, $result);
    }

    public function provideisIndexVariantOf()
    {
        return [
            [
                'asdfasdf',
                'my_index',
                false,
            ],
            [
                'my_index-fr-i18n',
                'my_index',
                true,
            ],
            [
                'foo_bar_index-de_at-i18n',
                'foo_bar_index',
                true,
            ],
            [
                'foo_bar_index_de_at_i18n',
                'foo_bar_index',
                false,
            ],
            [
                'foo_bar_foo_index_de-at-i18n',
                'foo_bar_index',
                false,
            ],
        ];
    }

    /**
     * @dataProvider provideisIndexVariantOf
     */
    public function testisIndexVariantOf($variantName, $indexName, $isVariant)
    {
        $strategy = new IndexStrategy();
        $result = $strategy->isIndexVariantOf($indexName, $variantName);
        $this->assertEquals($isVariant, $result);
    }

    public function provideDelocalizeIndexName()
    {
        return [
            ['hello-en-i18n', 'hello'],
            ['hello-test-en-i18n', 'hello-test'],
            ['hello-test-en_us-i18n', 'hello-test'],
        ];
    }

    /**
     * @dataProvider provideDelocalizeIndexName
     */
    public function testStrategy($indexName, $expected)
    {
        $strategy = new IndexStrategy();
        $result = $strategy->delocalizeIndexName($indexName);
        $this->assertEquals($expected, $result);
    }
}
