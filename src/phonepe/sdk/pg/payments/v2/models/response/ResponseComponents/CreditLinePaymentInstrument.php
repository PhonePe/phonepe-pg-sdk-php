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


namespace PhonePe\payments\v2\models\response\ResponseComponents;

use PhonePe\common\configs\Instruments;

class CreditLinePaymentInstrument extends Instrument
{
	public ?string	$ifsc;
	public ?string $accountHolderName;
	public ?string $providerAccountType;
	public ?string $bankId;
	public ?string $maskedAccountNumber;

	/**
	 * @param string|null $ifsc
	 * @param string|null $accountHolderName
	 * @param string|null $providerAccountType
	 * @param string|null $bankId
	 * @param string|null $maskedAccountNumber
	 */
	public function __construct(?string $ifsc = null, ?string $accountHolderName = null, ?string $providerAccountType = null, ?string $bankId = null, ?string $maskedAccountNumber = null)
	{
		$this->type = Instruments::CREDIT_LINE;
		$this->ifsc = $ifsc;
		$this->accountHolderName = $accountHolderName;
		$this->providerAccountType = $providerAccountType;
		$this->bankId = $bankId;
		$this->maskedAccountNumber = $maskedAccountNumber;
	}

	public function getIfsc(): ?string
	{
		return $this->ifsc;
	}

	public function getAccountHolderName(): ?string
	{
		return $this->accountHolderName;
	}

	public function getBankId(): ?string
	{
		return $this->bankId;
	}

	public function getMaskedAccountNumber(): ?string
	{
		return $this->maskedAccountNumber;
	}

	public function getProviderAccountType(): ?string
	{
		return $this->providerAccountType;
	}

}