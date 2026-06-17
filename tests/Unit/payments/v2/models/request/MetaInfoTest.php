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

namespace Tests\Unit\payments\v2\models\request;

use InvalidArgumentException;
use PhonePe\payments\v2\models\request\MetaInfo;
use Tests\Unit\BaseTestCase;

class MetaInfoTest extends BaseTestCase
{
    // -------------------------------------------------------------------------
    // Constructor and getters
    // -------------------------------------------------------------------------

    public function testConstructorSetsAllFifteenFields(): void
    {
        $metaInfo = new MetaInfo(
            'v1', 'v2', 'v3', 'v4', 'v5',
            'v6', 'v7', 'v8', 'v9', 'v10',
            'v11', 'v12', 'v13', 'v14', 'v15'
        );

        $this->assertEquals('v1',  $metaInfo->getUdf1());
        $this->assertEquals('v2',  $metaInfo->getUdf2());
        $this->assertEquals('v3',  $metaInfo->getUdf3());
        $this->assertEquals('v4',  $metaInfo->getUdf4());
        $this->assertEquals('v5',  $metaInfo->getUdf5());
        $this->assertEquals('v6',  $metaInfo->getUdf6());
        $this->assertEquals('v7',  $metaInfo->getUdf7());
        $this->assertEquals('v8',  $metaInfo->getUdf8());
        $this->assertEquals('v9',  $metaInfo->getUdf9());
        $this->assertEquals('v10', $metaInfo->getUdf10());
        $this->assertEquals('v11', $metaInfo->getUdf11());
        $this->assertEquals('v12', $metaInfo->getUdf12());
        $this->assertEquals('v13', $metaInfo->getUdf13());
        $this->assertEquals('v14', $metaInfo->getUdf14());
        $this->assertEquals('v15', $metaInfo->getUdf15());
    }

    public function testDefaultConstructorSetsAllFieldsToNull(): void
    {
        $metaInfo = new MetaInfo();

        for ($i = 1; $i <= 15; $i++) {
            $getter = 'getUdf' . $i;
            $this->assertNull($metaInfo->$getter(), "getUdf{$i}() should return null by default");
        }
    }

    // -------------------------------------------------------------------------
    // jsonSerialize — omits null fields
    // -------------------------------------------------------------------------

    public function testJsonSerializeOmitsNullFields(): void
    {
        $metaInfo = new MetaInfo('hello', null, null, null, 'world');

        $serialized = $metaInfo->jsonSerialize();

        $this->assertArrayHasKey('udf1', $serialized);
        $this->assertArrayHasKey('udf5', $serialized);
        $this->assertEquals('hello', $serialized['udf1']);
        $this->assertEquals('world', $serialized['udf5']);

        $this->assertArrayNotHasKey('udf2', $serialized);
        $this->assertArrayNotHasKey('udf3', $serialized);
        $this->assertArrayNotHasKey('udf4', $serialized);
        $this->assertArrayNotHasKey('udf6', $serialized);
    }

    public function testJsonSerializeReturnsEmptyObjectWhenAllNull(): void
    {
        $metaInfo = new MetaInfo();

        // Should return stdClass (serializes to {}) not array (serializes to [])
        $result = $metaInfo->jsonSerialize();
        $this->assertInstanceOf(\stdClass::class, $result);
        
        // Verify it serializes to {} in JSON
        $json = json_encode($result);
        $this->assertSame('{}', $json);
    }

    public function testJsonSerializeIncludesOnlySetFields(): void
    {
        $metaInfo = new MetaInfo(
            null, null, null, null, null,
            null, null, null, null, null,
            'tag1'
        );

        $serialized = $metaInfo->jsonSerialize();

        $this->assertCount(1, $serialized);
        $this->assertArrayHasKey('udf11', $serialized);
        $this->assertEquals('tag1', $serialized['udf11']);
    }

    // -------------------------------------------------------------------------
    // udf1–udf10: max length 256
    // -------------------------------------------------------------------------

    public function testUdf1AcceptsExactly256Chars(): void
    {
        $value = str_repeat('A', 256);
        $metaInfo = new MetaInfo($value);
        $this->assertEquals($value, $metaInfo->getUdf1());
    }

    public function testUdf1RejectsOver256Chars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/udf1/');
        $this->expectExceptionMessageMatches('/256/');

        new MetaInfo(str_repeat('A', 257));
    }

    public function testUdf5AcceptsExactly256Chars(): void
    {
        $value = str_repeat('B', 256);
        $metaInfo = new MetaInfo(null, null, null, null, $value);
        $this->assertEquals($value, $metaInfo->getUdf5());
    }

    public function testUdf5RejectsOver256Chars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/udf5/');
        $this->expectExceptionMessageMatches('/256/');

        new MetaInfo(null, null, null, null, str_repeat('B', 257));
    }

    /** @dataProvider udf6To10Provider */
    public function testUdf6To10RejectOver256Chars(int $udfNum): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches("/udf{$udfNum}/");
        $this->expectExceptionMessageMatches('/256/');

        $args = array_fill(0, 15, null);
        $args[$udfNum - 1] = str_repeat('X', 257);
        new MetaInfo(...$args);
    }

    public static function udf6To10Provider(): array
    {
        return [
            'udf6'  => [6],
            'udf7'  => [7],
            'udf8'  => [8],
            'udf9'  => [9],
            'udf10' => [10],
        ];
    }

    /** @dataProvider udf6To10Provider */
    public function testUdf6To10AcceptExactly256Chars(int $udfNum): void
    {
        $value = str_repeat('Y', 256);
        $args = array_fill(0, 15, null);
        $args[$udfNum - 1] = $value;
        $metaInfo = new MetaInfo(...$args);

        $getter = 'getUdf' . $udfNum;
        $this->assertEquals($value, $metaInfo->$getter());
    }

    // -------------------------------------------------------------------------
    // udf11–udf15: max length 50
    // -------------------------------------------------------------------------

    /** @dataProvider udf11To15Provider */
    public function testUdf11To15AcceptExactly50Chars(int $udfNum): void
    {
        $value = str_repeat('a', 50);
        $args = array_fill(0, 15, null);
        $args[$udfNum - 1] = $value;
        $metaInfo = new MetaInfo(...$args);

        $getter = 'getUdf' . $udfNum;
        $this->assertEquals($value, $metaInfo->$getter());
    }

    /** @dataProvider udf11To15Provider */
    public function testUdf11To15RejectOver50Chars(int $udfNum): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches("/udf{$udfNum}/");
        $this->expectExceptionMessageMatches('/50/');

        $args = array_fill(0, 15, null);
        $args[$udfNum - 1] = str_repeat('a', 51);
        new MetaInfo(...$args);
    }

    public static function udf11To15Provider(): array
    {
        return [
            'udf11' => [11],
            'udf12' => [12],
            'udf13' => [13],
            'udf14' => [14],
            'udf15' => [15],
        ];
    }

    // -------------------------------------------------------------------------
    // udf11–udf15: character validation
    // -------------------------------------------------------------------------

    /** @dataProvider invalidCharProvider */
    public function testUdf11To15RejectInvalidChars(int $udfNum, string $invalidValue): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches("/udf{$udfNum}/");

        $args = array_fill(0, 15, null);
        $args[$udfNum - 1] = $invalidValue;
        new MetaInfo(...$args);
    }

    public static function invalidCharProvider(): array
    {
        $cases = [];
        foreach ([11, 12, 13, 14, 15] as $n) {
            $cases["udf{$n} with !"  ] = [$n, 'invalid!'];
            $cases["udf{$n} with #"  ] = [$n, 'invalid#'];
            $cases["udf{$n} with \$" ] = [$n, 'invalid$'];
        }
        return $cases;
    }

    /** @dataProvider validCharProvider */
    public function testUdf11To15AllowValidChars(int $udfNum, string $validValue): void
    {
        $args = array_fill(0, 15, null);
        $args[$udfNum - 1] = $validValue;
        $metaInfo = new MetaInfo(...$args);

        $getter = 'getUdf' . $udfNum;
        $this->assertEquals($validValue, $metaInfo->$getter());
    }

    public static function validCharProvider(): array
    {
        return [
            'udf11 alphanumeric'  => [11, 'abc123'],
            'udf11 underscore'    => [11, 'my_tag'],
            'udf11 hyphen'        => [11, 'my-tag'],
            'udf11 space'         => [11, 'my tag'],
            'udf11 at'            => [11, 'user@host'],
            'udf11 dot'           => [11, 'file.txt'],
            'udf11 plus'          => [11, 'a+b'],
            'udf12 mixed valid'   => [12, 'Tag_1 @home.+end'],
            'udf15 all valid chars' => [15, 'aZ0_ -.@+'],
        ];
    }

    /** @dataProvider udf11To15Provider */
    public function testUdf11To15AllowEmptyString(int $udfNum): void
    {
        $args = array_fill(0, 15, null);
        $args[$udfNum - 1] = '';
        $metaInfo = new MetaInfo(...$args);

        $getter = 'getUdf' . $udfNum;
        $this->assertSame('', $metaInfo->$getter());
    }

    /** @dataProvider udf11To15Provider */
    public function testUdf11To15AllowNull(int $udfNum): void
    {
        $args = array_fill(0, 15, null);
        $metaInfo = new MetaInfo(...$args);

        $getter = 'getUdf' . $udfNum;
        $this->assertNull($metaInfo->$getter());
    }

    // -------------------------------------------------------------------------
    // udf1–udf10: multibyte / UTF-8 character counting
    // -------------------------------------------------------------------------

    public function testUdf1AcceptsExactly256MultiBytechars(): void
    {
        // 256 emoji = 256 characters but 1024 bytes — must be accepted
        $value = str_repeat('🎉', 256);
        $metaInfo = new MetaInfo($value);
        $this->assertEquals($value, $metaInfo->getUdf1());
    }

    public function testUdf1Rejects257MultiBytechars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/udf1/');
        $this->expectExceptionMessageMatches('/256/');

        new MetaInfo(str_repeat('🎉', 257));
    }

    // -------------------------------------------------------------------------
    // udf1–udf10 allow special characters that udf11–udf15 would reject
    // -------------------------------------------------------------------------

    public function testUdf1To10AllowSpecialCharsInvalidForUdf11To15(): void
    {
        $specialValue = 'chars!#$%^&*()';

        $metaInfo = new MetaInfo(
            $specialValue, $specialValue, $specialValue, $specialValue, $specialValue,
            $specialValue, $specialValue, $specialValue, $specialValue, $specialValue
        );

        for ($i = 1; $i <= 10; $i++) {
            $getter = 'getUdf' . $i;
            $this->assertEquals($specialValue, $metaInfo->$getter(), "udf{$i} should allow special chars");
        }
    }
}
