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

use PhonePe\payments\v2\models\request\CustomerDetails;
use Tests\Unit\BaseTestCase;
use InvalidArgumentException;

class CustomerDetailsTest extends BaseTestCase
{
    public function testCustomerDetailsWithValidData(): void
    {
        $customerDetails = new CustomerDetails(
            'John Doe',
            'john.doe@example.com',
            '9876543210'
        );

        $this->assertEquals('John Doe', $customerDetails->getName());
        $this->assertEquals('john.doe@example.com', $customerDetails->getEmail());
        $this->assertEquals('9876543210', $customerDetails->getPhoneNumber());
    }

    public function testCustomerDetailsWithAllNullValues(): void
    {
        $customerDetails = new CustomerDetails(null, null, null);

        $this->assertNull($customerDetails->getName());
        $this->assertNull($customerDetails->getEmail());
        $this->assertNull($customerDetails->getPhoneNumber());
    }

    public function testCustomerDetailsWithOnlyName(): void
    {
        $customerDetails = new CustomerDetails('John Doe', null, null);

        $this->assertEquals('John Doe', $customerDetails->getName());
        $this->assertNull($customerDetails->getEmail());
        $this->assertNull($customerDetails->getPhoneNumber());
    }

    public function testCustomerDetailsWithOnlyEmail(): void
    {
        $customerDetails = new CustomerDetails(null, 'john@example.com', null);

        $this->assertNull($customerDetails->getName());
        $this->assertEquals('john@example.com', $customerDetails->getEmail());
        $this->assertNull($customerDetails->getPhoneNumber());
    }

    public function testCustomerDetailsWithOnlyPhoneNumber(): void
    {
        $customerDetails = new CustomerDetails(null, null, '9876543210');

        $this->assertNull($customerDetails->getName());
        $this->assertNull($customerDetails->getEmail());
        $this->assertEquals('9876543210', $customerDetails->getPhoneNumber());
    }

    /**
     * @dataProvider validPhoneNumberProvider
     */
    public function testValidPhoneNumberFormats(string $phoneNumber): void
    {
        $customerDetails = new CustomerDetails(null, null, $phoneNumber);
        $this->assertEquals($phoneNumber, $customerDetails->getPhoneNumber());
    }

    public static function validPhoneNumberProvider(): array
    {
        return [
            'Indian 10-digit' => ['9876543210'],
            'E.164 with +91' => ['+919876543210'],
            'E.164 with +1' => ['+14155552671'],
            'E.164 with +44' => ['+447911123456'],
            '11-digit number' => ['12345678901'],
            '15-digit number' => ['123456789012345'],
        ];
    }

    /**
     * @dataProvider invalidPhoneNumberProvider
     */
    public function testInvalidPhoneNumberFormats(string $phoneNumber, string $expectedMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        new CustomerDetails(null, null, $phoneNumber);
    }

    public static function invalidPhoneNumberProvider(): array
    {
        return [
            'Too short' => [
                '98765',
                "Invalid phoneNumber '98765': expected a 10-digit number or E.164 format (e.g. '+919876543210')."
            ],
            'Too long' => [
                '1234567890123456',
                "Invalid phoneNumber '1234567890123456': expected a 10-digit number or E.164 format (e.g. '+919876543210')."
            ],
            'Contains letters' => [
                '987654321a',
                "Invalid phoneNumber '987654321a': expected a 10-digit number or E.164 format (e.g. '+919876543210')."
            ],
            'Contains spaces' => [
                '98765 43210',
                "Invalid phoneNumber '98765 43210': expected a 10-digit number or E.164 format (e.g. '+919876543210')."
            ],
            'Contains hyphens' => [
                '9876-543-210',
                "Invalid phoneNumber '9876-543-210': expected a 10-digit number or E.164 format (e.g. '+919876543210')."
            ],
            'Contains special chars' => [
                '98765@43210',
                "Invalid phoneNumber '98765@43210': expected a 10-digit number or E.164 format (e.g. '+919876543210')."
            ],
            'Empty string' => [
                '',
                "Invalid phoneNumber '': expected a 10-digit number or E.164 format (e.g. '+919876543210')."
            ],
        ];
    }

    /**
     * @dataProvider validEmailProvider
     */
    public function testValidEmailFormats(string $email): void
    {
        $customerDetails = new CustomerDetails(null, $email, null);
        $this->assertEquals($email, $customerDetails->getEmail());
    }

    public static function validEmailProvider(): array
    {
        return [
            'Simple email' => ['user@example.com'],
            'Email with dots' => ['user.name@example.com'],
            'Email with plus' => ['user+tag@example.com'],
            'Email with subdomain' => ['user@mail.example.com'],
            'Email with numbers' => ['user123@example.com'],
            'Email with hyphens' => ['user-name@example.com'],
        ];
    }

    /**
     * @dataProvider invalidEmailProvider
     */
    public function testInvalidEmailFormats(string $email): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email address: '$email'.");

        new CustomerDetails(null, $email, null);
    }

    public static function invalidEmailProvider(): array
    {
        return [
            'Missing @' => ['userexample.com'],
            'Missing domain' => ['user@'],
            'Missing local part' => ['@example.com'],
            'Double @' => ['user@@example.com'],
            'Spaces in email' => ['user name@example.com'],
            'Missing TLD' => ['user@example'],
            'Empty string' => [''],
        ];
    }

    public function testJsonSerializationWithAllFields(): void
    {
        $customerDetails = new CustomerDetails(
            'John Doe',
            'john.doe@example.com',
            '9876543210'
        );

        $json = json_encode($customerDetails);
        $decoded = json_decode($json, true);

        $this->assertArrayHasKey('name', $decoded);
        $this->assertArrayHasKey('email', $decoded);
        $this->assertArrayHasKey('phoneNumber', $decoded);
        $this->assertEquals('John Doe', $decoded['name']);
        $this->assertEquals('john.doe@example.com', $decoded['email']);
        $this->assertEquals('9876543210', $decoded['phoneNumber']);
    }

    public function testJsonSerializationWithNullFields(): void
    {
        $customerDetails = new CustomerDetails(null, null, null);

        $json = json_encode($customerDetails);
        $decoded = json_decode($json, true);

        $this->assertArrayNotHasKey('name', $decoded);
        $this->assertArrayNotHasKey('email', $decoded);
        $this->assertArrayNotHasKey('phoneNumber', $decoded);
        $this->assertEmpty($decoded);
    }

    public function testJsonSerializationWithPartialFields(): void
    {
        $customerDetails = new CustomerDetails('John Doe', null, '9876543210');

        $json = json_encode($customerDetails);
        $decoded = json_decode($json, true);

        $this->assertArrayHasKey('name', $decoded);
        $this->assertArrayNotHasKey('email', $decoded);
        $this->assertArrayHasKey('phoneNumber', $decoded);
        $this->assertEquals('John Doe', $decoded['name']);
        $this->assertEquals('9876543210', $decoded['phoneNumber']);
    }

    public function testSpecialCharactersInName(): void
    {
        $specialName = "John O'Reilly-Smith Jr.";
        $customerDetails = new CustomerDetails($specialName, 'john@example.com', '9876543210');

        $this->assertEquals($specialName, $customerDetails->getName());
    }

    public function testUnicodeCharactersInName(): void
    {
        $unicodeName = 'José García Müller 中文名';
        $customerDetails = new CustomerDetails($unicodeName, 'jose@example.com', '9876543210');

        $this->assertEquals($unicodeName, $customerDetails->getName());
        
        $json = json_encode($customerDetails);
        $decoded = json_decode($json, true);
        $this->assertEquals($unicodeName, $decoded['name']);
    }

    public function testLongNameValue(): void
    {
        $longName = str_repeat('A', 200);
        $customerDetails = new CustomerDetails($longName, 'test@example.com', '9876543210');

        $this->assertEquals($longName, $customerDetails->getName());
    }

    public function testEmailWithInternationalDomain(): void
    {
        $internationalEmail = 'user@example.co.uk';
        $customerDetails = new CustomerDetails(null, $internationalEmail, null);

        $this->assertEquals($internationalEmail, $customerDetails->getEmail());
    }
}
