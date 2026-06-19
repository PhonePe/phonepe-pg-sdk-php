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


namespace PhonePe\payments\v2\models\request;

class StandardCheckoutPayRequest implements \JsonSerializable
{
	private string $merchantOrderId;
	private int $amount;
	private $metaInfo;
	private array $paymentFlow;
	private ?PrefillUserLoginDetails $prefillUserLoginDetails;
	private ?CustomerDetails $customerDetails;

	/**
	 * @param string $merchantOrderId
	 * @param int $amount
	 * @param $metaInfo
	 * @param array $paymentFlow
	 * @param PrefillUserLoginDetails|null $prefillUserLoginDetails
	 */
	public function __construct($merchantOrderId, $amount, $metaInfo, $paymentFlow, ?PrefillUserLoginDetails $prefillUserLoginDetails = null, ?CustomerDetails $customerDetails = null)
	{
		$this->merchantOrderId = $merchantOrderId;
		$this->amount = $amount;
		$this->metaInfo = $metaInfo;
		$this->paymentFlow = $paymentFlow;
		$this->prefillUserLoginDetails = $prefillUserLoginDetails;
		$this->customerDetails = $customerDetails;
	}

	/**
	 * @return string
	 */
	public function getMerchantOrderId()
	{
		return $this->merchantOrderId;
	}

	/**
	 * @return int
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @return mixed
	 */
	public function getMetaInfo()
	{
		return $this->metaInfo;
	}

	/**
	 * @return array
	 */
	public function getPaymentFlow()
	{
		return $this->paymentFlow;
	}

	/**
	 * @return PrefillUserLoginDetails|null
	 */
	public function getPrefillUserLoginDetails(): ?PrefillUserLoginDetails
	{
		return $this->prefillUserLoginDetails;
	}

    /**
     * @return CustomerDetails|null
     */
    public function getCustomerDetails(): ?CustomerDetails
    {
       return $this->customerDetails;
    }

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		$result = [
			'merchantOrderId' => $this->merchantOrderId,
			'amount' => $this->amount,
			'metaInfo' => $this->metaInfo,
			'paymentFlow' => $this->paymentFlow,
		];
		if ($this->prefillUserLoginDetails !== null) {
			$result['prefillUserLoginDetails'] = $this->prefillUserLoginDetails;
		}
        if ($this->customerDetails !== null) {
            $result['customerDetails'] = $this->customerDetails;
        }
		return $result;
	}


}