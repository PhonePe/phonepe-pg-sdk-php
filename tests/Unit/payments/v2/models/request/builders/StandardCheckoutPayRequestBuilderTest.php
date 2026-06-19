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

namespace Tests\Unit\payments\v2\models\request\builders;

use PhonePe\payments\v2\models\request\builders\StandardCheckoutPayRequestBuilder;
use PhonePe\payments\v2\models\request\MetaInfo;
use PhonePe\payments\v2\models\request\PrefillUserLoginDetails;
use PhonePe\payments\v2\models\request\StandardCheckoutPayRequest;
use PhonePe\payments\v2\standardCheckout\StandardCheckoutConstants;
use Tests\Fixtures\TestDataProvider;
use Tests\Unit\BaseTestCase;

class StandardCheckoutPayRequestBuilderTest extends BaseTestCase
{
    public function testBuilderCreation(): void
    {
        $builder = StandardCheckoutPayRequestBuilder::builder();
        
        $this->assertInstanceOf(StandardCheckoutPayRequestBuilder::class, $builder);
    }

    public function testBuildMinimalPaymentRequest(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->build();

        $this->assertInstanceOf(StandardCheckoutPayRequest::class, $request);
        $this->assertEquals($testData['merchantOrderId'], $request->getMerchantOrderId());
        $this->assertEquals($testData['amount'], $request->getAmount());
    }

    public function testBuildPaymentRequestWithMetaInfo(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->udf1($testData['metaInfo']['udf1'])
            ->udf2($testData['metaInfo']['udf2'])
            ->build();

        $this->assertInstanceOf(StandardCheckoutPayRequest::class, $request);
        
        $metaInfo = $request->getMetaInfo();
        $this->assertInstanceOf(MetaInfo::class, $metaInfo);
        $this->assertEquals($testData['metaInfo']['udf1'], $metaInfo->getUdf1());
        $this->assertEquals($testData['metaInfo']['udf2'], $metaInfo->getUdf2());
    }

    public function testBuildPaymentRequestWithAllUdfFields(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->udf1('udf1_value')
            ->udf2('udf2_value')
            ->udf3('udf3_value')
            ->udf4('udf4_value')
            ->udf5('udf5_value')
            ->build();

        $metaInfo = $request->getMetaInfo();
        $this->assertEquals('udf1_value', $metaInfo->getUdf1());
        $this->assertEquals('udf2_value', $metaInfo->getUdf2());
        $this->assertEquals('udf3_value', $metaInfo->getUdf3());
        $this->assertEquals('udf4_value', $metaInfo->getUdf4());
        $this->assertEquals('udf5_value', $metaInfo->getUdf5());
    }

    public function testPaymentFlowStructure(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->build();

        $paymentFlow = $request->getPaymentFlow();
        
        $this->assertIsArray($paymentFlow);
        $this->assertArrayHasKey('type', $paymentFlow);
        $this->assertArrayHasKey('message', $paymentFlow);
        $this->assertArrayHasKey('merchantUrls', $paymentFlow);
        
        $this->assertEquals(StandardCheckoutConstants::STANDARD_CHECKOUT_PAYMENT_FLOW_TYPE, $paymentFlow['type']);
        $this->assertEquals($testData['message'], $paymentFlow['message']);
        $this->assertArrayHasKey('redirectUrl', $paymentFlow['merchantUrls']);
        $this->assertEquals($testData['redirectUrl'], $paymentFlow['merchantUrls']['redirectUrl']);
    }

    public function testJsonSerialization(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->udf1($testData['metaInfo']['udf1'])
            ->build();

        $json = json_encode($request);
        $this->assertIsString($json);
        
        $decoded = json_decode($json, true);
        $this->assertIsArray($decoded);
        
        $this->assertJsonContains([
            'merchantOrderId' => $testData['merchantOrderId'],
            'amount' => $testData['amount']
        ], $json);
    }

    public function testFluentInterface(): void
    {
        $builder = StandardCheckoutPayRequestBuilder::builder();
        
        // Test that each method returns the builder instance for chaining
        $result = $builder->merchantOrderId('test');
        $this->assertSame($builder, $result);
        
        $result = $builder->amount(1000);
        $this->assertSame($builder, $result);
        
        $result = $builder->message('test message');
        $this->assertSame($builder, $result);
        
        $result = $builder->redirectUrl('https://example.com');
        $this->assertSame($builder, $result);
        
        $result = $builder->udf1('value1');
        $this->assertSame($builder, $result);
    }

    /**
     * @dataProvider amountDataProvider
     */
    public function testAmountVariations(int $amount): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($amount)
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->build();

        $this->assertEquals($amount, $request->getAmount());
    }

    public static function amountDataProvider(): array
    {
        return TestDataProvider::paymentAmountDataProvider();
    }

    public function testNullMetaInfoHandling(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->build();

        // MetaInfo is always created; with no UDF fields set all getters return null
        $metaInfo = $request->getMetaInfo();
        $this->assertInstanceOf(MetaInfo::class, $metaInfo);
        $this->assertNull($metaInfo->getUdf1());
    }

    public function testSpecialCharactersInFields(): void
    {
        $specialOrderId = 'ORDER_TEST_@#$%^&*()_+';
        $specialMessage = 'Payment with special chars: ñáéíóú 中文 العربية';
        $specialUrl = 'https://example.com/callback?param=value&other=test';
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($specialOrderId)
            ->amount(1000)
            ->message($specialMessage)
            ->redirectUrl($specialUrl)
            ->udf1('UDF with émojis: 🎉💳')
            ->build();

        $this->assertEquals($specialOrderId, $request->getMerchantOrderId());
        $paymentFlow = $request->getPaymentFlow();
        $this->assertEquals($specialMessage, $paymentFlow['message']);
        $this->assertEquals($specialUrl, $paymentFlow['merchantUrls']['redirectUrl']);
        
        $metaInfo = $request->getMetaInfo();
        $this->assertEquals('UDF with émojis: 🎉💳', $metaInfo->getUdf1());
    }

    public function testLongFieldValues(): void
    {
        $longOrderId = str_repeat('A', 100);
        $longMessage = str_repeat('This is a very long payment message. ', 10);
        $longUrl = 'https://example.com/very-long-callback-url-' . str_repeat('param', 20);
        $longUdf = str_repeat('A', 256); // exactly at the 256-char limit for udf1-udf10
        
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($longOrderId)
            ->amount(50000)
            ->message($longMessage)
            ->redirectUrl($longUrl)
            ->udf1($longUdf)
            ->build();

        $this->assertEquals($longOrderId, $request->getMerchantOrderId());
        $paymentFlow = $request->getPaymentFlow();
        $this->assertEquals($longMessage, $paymentFlow['message']);
        $this->assertEquals($longUrl, $paymentFlow['merchantUrls']['redirectUrl']);
        
        $metaInfo = $request->getMetaInfo();
        $this->assertEquals($longUdf, $metaInfo->getUdf1());
    }

    public function testBuildPaymentRequestWithPrefillUserLoginDetails(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        $prefillDetails = new PrefillUserLoginDetails('9876543210');

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->prefillUserLoginDetails($prefillDetails)
            ->build();

        $this->assertInstanceOf(StandardCheckoutPayRequest::class, $request);
        $retrieved = $request->getPrefillUserLoginDetails();
        $this->assertInstanceOf(PrefillUserLoginDetails::class, $retrieved);
        $this->assertEquals('9876543210', $retrieved->getPhoneNumber());
    }

    public function testPrefillUserLoginDetailsAbsentByDefault(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->build();

        $this->assertNull($request->getPrefillUserLoginDetails());
    }

    public function testPrefillUserLoginDetailsOmittedFromJsonWhenNull(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->build();

        $json = json_encode($request);
        $decoded = json_decode($json, true);
        $this->assertArrayNotHasKey('prefillUserLoginDetails', $decoded);
    }

    public function testPrefillUserLoginDetailsPresentInJsonWhenSet(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        $prefillDetails = new PrefillUserLoginDetails('9876543210');

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->prefillUserLoginDetails($prefillDetails)
            ->build();

        $json = json_encode($request);
        $decoded = json_decode($json, true);
        $this->assertArrayHasKey('prefillUserLoginDetails', $decoded);
        $this->assertEquals('9876543210', $decoded['prefillUserLoginDetails']['phoneNumber']);
    }

    public function testPrefillUserLoginDetailsFluentInterface(): void
    {
        $builder = StandardCheckoutPayRequestBuilder::builder();
        $prefillDetails = new PrefillUserLoginDetails('9876543210');

        $result = $builder->prefillUserLoginDetails($prefillDetails);
        $this->assertSame($builder, $result);
    }

    public function testBuildPaymentRequestWithCustomerDetails(): void
    {
        $builder = StandardCheckoutPayRequestBuilder::builder();
        $result = $builder->customerDetails(new CustomerDetails('John Doe', 'john.doe@example.com', '9876543210'));
        $this->assertSame($builder, $result);
    }

    public function testBuildPaymentRequestWithInvalidCustomerDetailsCustomerDetails(): void
    {
        $emailId = "";
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email address: '. "'$emailId'.");
        $builder = StandardCheckoutPayRequestBuilder::builder();
        $result = $builder->customerDetails(new CustomerDetails('John Doe', $emailId, '9876543210'));
    }

    public function testBuildPaymentRequestWithValidCustomerDetails(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->customerDetails(new CustomerDetails('John Doe', 'john.doe@example.com', '9876543210'))
            ->build();

        $this->assertInstanceOf(StandardCheckoutPayRequest::class, $request);
        $customerDetails = $request->getCustomerDetails();
        $this->assertInstanceOf(CustomerDetails::class, $customerDetails);
        $this->assertEquals('John Doe', $customerDetails->getName());
        $this->assertEquals('john.doe@example.com', $customerDetails->getEmail());
        $this->assertEquals('9876543210', $customerDetails->getPhoneNumber());
    }

    public function testCustomerDetailsAbsentByDefault(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->build();

        $this->assertNull($request->getCustomerDetails());
    }

    public function testCustomerDetailsOmittedFromJsonWhenNull(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->build();

        $json = json_encode($request);
        $decoded = json_decode($json, true);
        $this->assertArrayNotHasKey('customerDetails', $decoded);
    }

    public function testCustomerDetailsPresentInJsonWhenSet(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->customerDetails(new CustomerDetails('John Doe', 'john.doe@example.com', '9876543210'))
            ->build();

        $json = json_encode($request);
        $decoded = json_decode($json, true);
        $this->assertArrayHasKey('customerDetails', $decoded);
        $this->assertEquals('John Doe', $decoded['customerDetails']['name']);
        $this->assertEquals('john.doe@example.com', $decoded['customerDetails']['email']);
        $this->assertEquals('9876543210', $decoded['customerDetails']['phoneNumber']);
    }

    public function testCustomerDetailsWithPartialData(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->customerDetails(new CustomerDetails('John Doe', null, '9876543210'))
            ->build();

        $customerDetails = $request->getCustomerDetails();
        $this->assertEquals('John Doe', $customerDetails->getName());
        $this->assertNull($customerDetails->getEmail());
        $this->assertEquals('9876543210', $customerDetails->getPhoneNumber());

        $json = json_encode($request);
        $decoded = json_decode($json, true);
        $this->assertArrayHasKey('customerDetails', $decoded);
        $this->assertArrayHasKey('name', $decoded['customerDetails']);
        $this->assertArrayNotHasKey('email', $decoded['customerDetails']);
        $this->assertArrayHasKey('phoneNumber', $decoded['customerDetails']);
    }

    public function testCustomerDetailsFluentInterface(): void
    {
        $builder = StandardCheckoutPayRequestBuilder::builder();

        $result = $builder->customerDetails(new CustomerDetails('John Doe', 'john@example.com', '9876543210'));
        $this->assertSame($builder, $result);
    }

    public function testCustomerDetailsWithInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email address: 'invalid-email'.");

        StandardCheckoutPayRequestBuilder::builder()
            ->customerDetails(new CustomerDetails('John Doe', 'invalid-email', '9876543210'));
    }

    public function testCustomerDetailsWithInvalidPhoneNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid phoneNumber '12345': expected a 10-digit number or E.164 format");

        StandardCheckoutPayRequestBuilder::builder()
            ->customerDetails(new CustomerDetails('John Doe', 'john@example.com', '12345'));
    }

    public function testBuildPaymentRequestWithBothPrefillAndCustomerDetails(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        $prefillDetails = new PrefillUserLoginDetails('9876543210');

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->prefillUserLoginDetails($prefillDetails)
            ->customerDetails(new CustomerDetails('John Doe', 'john.doe@example.com', '9876543210'))
            ->build();

        $this->assertInstanceOf(StandardCheckoutPayRequest::class, $request);
        
        // Verify prefillUserLoginDetails
        $retrievedPrefill = $request->getPrefillUserLoginDetails();
        $this->assertInstanceOf(PrefillUserLoginDetails::class, $retrievedPrefill);
        $this->assertEquals('9876543210', $retrievedPrefill->getPhoneNumber());

        // Verify customerDetails
        $customerDetails = $request->getCustomerDetails();
        $this->assertInstanceOf(CustomerDetails::class, $customerDetails);
        $this->assertEquals('John Doe', $customerDetails->getName());
        $this->assertEquals('john.doe@example.com', $customerDetails->getEmail());
        $this->assertEquals('9876543210', $customerDetails->getPhoneNumber());
    }

    public function testJsonSerializationWithBothPrefillAndCustomerDetails(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        $prefillDetails = new PrefillUserLoginDetails('9876543210');

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->prefillUserLoginDetails($prefillDetails)
            ->customerDetails(new CustomerDetails('John Doe', 'john.doe@example.com', '9876543210'))
            ->build();

        $json = json_encode($request);
        $decoded = json_decode($json, true);

        $this->assertArrayHasKey('prefillUserLoginDetails', $decoded);
        $this->assertEquals('9876543210', $decoded['prefillUserLoginDetails']['phoneNumber']);

        $this->assertArrayHasKey('customerDetails', $decoded);
        $this->assertEquals('John Doe', $decoded['customerDetails']['name']);
        $this->assertEquals('john.doe@example.com', $decoded['customerDetails']['email']);
        $this->assertEquals('9876543210', $decoded['customerDetails']['phoneNumber']);
    }

    public function testCustomerDetailsWithE164PhoneNumber(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->customerDetails(new CustomerDetails('John Doe', 'john@example.com', '+919876543210'))
            ->build();

        $customerDetails = $request->getCustomerDetails();
        $this->assertEquals('+919876543210', $customerDetails->getPhoneNumber());
    }

    public function testBackwardCompatibilityPrefillUserLoginDetailsWithObject(): void
    {
        $testData = TestDataProvider::getPaymentRequestData();
        $prefillDetails = new PrefillUserLoginDetails('9876543210');

        // Test that the old API signature still works (backward compatibility)
        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($testData['merchantOrderId'])
            ->amount($testData['amount'])
            ->message($testData['message'])
            ->redirectUrl($testData['redirectUrl'])
            ->prefillUserLoginDetails($prefillDetails)
            ->build();

        $this->assertInstanceOf(StandardCheckoutPayRequest::class, $request);
        $retrieved = $request->getPrefillUserLoginDetails();
        $this->assertInstanceOf(PrefillUserLoginDetails::class, $retrieved);
        $this->assertEquals('9876543210', $retrieved->getPhoneNumber());
    }
}
