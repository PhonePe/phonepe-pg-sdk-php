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

class PrefillUserLoginDetails implements \JsonSerializable
{
	private ?string $phoneNumber;

	/**
	 * @param string|null $phoneNumber The user's mobile number to pre-fill on the PhonePe payment page.
	 *                                 Expected format: 10-digit Indian mobile number (e.g. "9876543210"),
	 *                                 or E.164 format with country code (e.g. "+919876543210").
	 */
	public function __construct(?string $phoneNumber = null)
	{
		$this->phoneNumber = $phoneNumber;
	}

	/**
	 * @return string|null
	 */
	public function getPhoneNumber(): ?string
	{
		return $this->phoneNumber;
	}

	public function jsonSerialize(): array
	{
		$result = [];
		if ($this->phoneNumber !== null) {
			$result['phoneNumber'] = $this->phoneNumber;
		}
		return $result;
	}
}
