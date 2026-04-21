<?php

/*
*  Copyright (c) 2025 Original Author(s), PhonePe India Pvt. Ltd.
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*  http://www.apache.org/licenses/LICENSE-2.0
*
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*  limitations under the License.
*/

namespace Tests\Unit\payments\v2\models\response\ResponseComponents;

use PhonePe\payments\v2\models\response\ResponseComponents\MetaInfo;
use Tests\Unit\BaseTestCase;

class MetaInfoTest extends BaseTestCase
{
    public function testMetaInfoConstructorSetsAllFields(): void
    {
        $metaInfo = new MetaInfo(
            'val1', 'val2', 'val3', 'val4', 'val5',
            'val6', 'val7', 'val8', 'val9', 'val10',
            'val11', 'val12', 'val13', 'val14', 'val15'
        );

        $this->assertEquals('val1', $metaInfo->getUdf1());
        $this->assertEquals('val2', $metaInfo->getUdf2());
        $this->assertEquals('val3', $metaInfo->getUdf3());
        $this->assertEquals('val4', $metaInfo->getUdf4());
        $this->assertEquals('val5', $metaInfo->getUdf5());
        $this->assertEquals('val6', $metaInfo->getUdf6());
        $this->assertEquals('val7', $metaInfo->getUdf7());
        $this->assertEquals('val8', $metaInfo->getUdf8());
        $this->assertEquals('val9', $metaInfo->getUdf9());
        $this->assertEquals('val10', $metaInfo->getUdf10());
        $this->assertEquals('val11', $metaInfo->getUdf11());
        $this->assertEquals('val12', $metaInfo->getUdf12());
        $this->assertEquals('val13', $metaInfo->getUdf13());
        $this->assertEquals('val14', $metaInfo->getUdf14());
        $this->assertEquals('val15', $metaInfo->getUdf15());
    }

    public function testMetaInfoDefaultsAllFieldsToNull(): void
    {
        $metaInfo = new MetaInfo();

        $this->assertNull($metaInfo->getUdf1());
        $this->assertNull($metaInfo->getUdf2());
        $this->assertNull($metaInfo->getUdf3());
        $this->assertNull($metaInfo->getUdf4());
        $this->assertNull($metaInfo->getUdf5());
        $this->assertNull($metaInfo->getUdf6());
        $this->assertNull($metaInfo->getUdf7());
        $this->assertNull($metaInfo->getUdf8());
        $this->assertNull($metaInfo->getUdf9());
        $this->assertNull($metaInfo->getUdf10());
        $this->assertNull($metaInfo->getUdf11());
        $this->assertNull($metaInfo->getUdf12());
        $this->assertNull($metaInfo->getUdf13());
        $this->assertNull($metaInfo->getUdf14());
        $this->assertNull($metaInfo->getUdf15());
    }

    public function testMetaInfoHasUdf6ThroughUdf15(): void
    {
        $metaInfo = new MetaInfo();

        for ($i = 6; $i <= 15; $i++) {
            $this->assertTrue(
                property_exists($metaInfo, 'udf' . $i),
                "Property 'udf{$i}' should exist on MetaInfo"
            );
        }
    }

    public function testMetaInfoGettersReturnCorrectValues(): void
    {
        $metaInfo = new MetaInfo(
            null, null, null, null, null,
            null, null, null, null, null,
            'udf11val', 'udf12val', 'udf13val', 'udf14val', 'udf15val'
        );

        $this->assertNull($metaInfo->getUdf6());
        $this->assertNull($metaInfo->getUdf7());
        $this->assertNull($metaInfo->getUdf8());
        $this->assertNull($metaInfo->getUdf9());
        $this->assertNull($metaInfo->getUdf10());
        $this->assertEquals('udf11val', $metaInfo->getUdf11());
        $this->assertEquals('udf12val', $metaInfo->getUdf12());
        $this->assertEquals('udf13val', $metaInfo->getUdf13());
        $this->assertEquals('udf14val', $metaInfo->getUdf14());
        $this->assertEquals('udf15val', $metaInfo->getUdf15());
    }
}
