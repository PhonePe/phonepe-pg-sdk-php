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

class MetaInfo implements \JsonSerializable
{
	private ?string $udf1;
	private ?string $udf2;
	private ?string $udf3;
	private ?string $udf4;
	private ?string $udf5;
	private ?string $udf6;
	private ?string $udf7;
	private ?string $udf8;
	private ?string $udf9;
	private ?string $udf10;
	private ?string $udf11;
	private ?string $udf12;
	private ?string $udf13;
	private ?string $udf14;
	private ?string $udf15;

	private const UDF1_TO_10_MAX_LENGTH = 256;
	private const UDF11_TO_15_MAX_LENGTH = 50;
	private const UDF11_TO_15_PATTERN = '/^[a-zA-Z0-9_\- @.+]*$/';

	/**
	 * @param string|null $udf1
	 * @param string|null $udf2
	 * @param string|null $udf3
	 * @param string|null $udf4
	 * @param string|null $udf5
	 * @param string|null $udf6
	 * @param string|null $udf7
	 * @param string|null $udf8
	 * @param string|null $udf9
	 * @param string|null $udf10
	 * @param string|null $udf11
	 * @param string|null $udf12
	 * @param string|null $udf13
	 * @param string|null $udf14
	 * @param string|null $udf15
	 * @throws \InvalidArgumentException
	 */
	public function __construct(
		?string $udf1 = null,
		?string $udf2 = null,
		?string $udf3 = null,
		?string $udf4 = null,
		?string $udf5 = null,
		?string $udf6 = null,
		?string $udf7 = null,
		?string $udf8 = null,
		?string $udf9 = null,
		?string $udf10 = null,
		?string $udf11 = null,
		?string $udf12 = null,
		?string $udf13 = null,
		?string $udf14 = null,
		?string $udf15 = null
	) {
		$this->validateUdf1To10('udf1', $udf1);
		$this->validateUdf1To10('udf2', $udf2);
		$this->validateUdf1To10('udf3', $udf3);
		$this->validateUdf1To10('udf4', $udf4);
		$this->validateUdf1To10('udf5', $udf5);
		$this->validateUdf1To10('udf6', $udf6);
		$this->validateUdf1To10('udf7', $udf7);
		$this->validateUdf1To10('udf8', $udf8);
		$this->validateUdf1To10('udf9', $udf9);
		$this->validateUdf1To10('udf10', $udf10);

		$this->validateUdf11To15('udf11', $udf11);
		$this->validateUdf11To15('udf12', $udf12);
		$this->validateUdf11To15('udf13', $udf13);
		$this->validateUdf11To15('udf14', $udf14);
		$this->validateUdf11To15('udf15', $udf15);

		$this->udf1 = $udf1;
		$this->udf2 = $udf2;
		$this->udf3 = $udf3;
		$this->udf4 = $udf4;
		$this->udf5 = $udf5;
		$this->udf6 = $udf6;
		$this->udf7 = $udf7;
		$this->udf8 = $udf8;
		$this->udf9 = $udf9;
		$this->udf10 = $udf10;
		$this->udf11 = $udf11;
		$this->udf12 = $udf12;
		$this->udf13 = $udf13;
		$this->udf14 = $udf14;
		$this->udf15 = $udf15;
	}

	private function validateUdf1To10(string $field, ?string $value): void
	{
		if ($value !== null && mb_strlen($value, 'UTF-8') > self::UDF1_TO_10_MAX_LENGTH) {
			throw new \InvalidArgumentException(
				"{$field} must not exceed " . self::UDF1_TO_10_MAX_LENGTH . " characters"
			);
		}
	}

	private function validateUdf11To15(string $field, ?string $value): void
	{
		if ($value === null) {
			return;
		}

		if (mb_strlen($value, 'UTF-8') > self::UDF11_TO_15_MAX_LENGTH) {
			throw new \InvalidArgumentException(
				"{$field} must not exceed " . self::UDF11_TO_15_MAX_LENGTH . " characters"
			);
		}

		if (!preg_match(self::UDF11_TO_15_PATTERN, $value)) {
			throw new \InvalidArgumentException(
				"{$field} contains invalid characters; only alphanumeric, _, -, space, @, ., + are allowed"
			);
		}
	}

	public function jsonSerialize(): array|object
	{
		$result = [];

		if ($this->udf1 !== null) $result['udf1'] = $this->udf1;
		if ($this->udf2 !== null) $result['udf2'] = $this->udf2;
		if ($this->udf3 !== null) $result['udf3'] = $this->udf3;
		if ($this->udf4 !== null) $result['udf4'] = $this->udf4;
		if ($this->udf5 !== null) $result['udf5'] = $this->udf5;
		if ($this->udf6 !== null) $result['udf6'] = $this->udf6;
		if ($this->udf7 !== null) $result['udf7'] = $this->udf7;
		if ($this->udf8 !== null) $result['udf8'] = $this->udf8;
		if ($this->udf9 !== null) $result['udf9'] = $this->udf9;
		if ($this->udf10 !== null) $result['udf10'] = $this->udf10;
		if ($this->udf11 !== null) $result['udf11'] = $this->udf11;
		if ($this->udf12 !== null) $result['udf12'] = $this->udf12;
		if ($this->udf13 !== null) $result['udf13'] = $this->udf13;
		if ($this->udf14 !== null) $result['udf14'] = $this->udf14;
		if ($this->udf15 !== null) $result['udf15'] = $this->udf15;

		// Force JSON object {} instead of array [] when empty
		return empty($result) ? new \stdClass() : $result;
	}

	public function getUdf1(): ?string
	{
		return $this->udf1;
	}

	public function getUdf2(): ?string
	{
		return $this->udf2;
	}

	public function getUdf3(): ?string
	{
		return $this->udf3;
	}

	public function getUdf4(): ?string
	{
		return $this->udf4;
	}

	public function getUdf5(): ?string
	{
		return $this->udf5;
	}

	public function getUdf6(): ?string
	{
		return $this->udf6;
	}

	public function getUdf7(): ?string
	{
		return $this->udf7;
	}

	public function getUdf8(): ?string
	{
		return $this->udf8;
	}

	public function getUdf9(): ?string
	{
		return $this->udf9;
	}

	public function getUdf10(): ?string
	{
		return $this->udf10;
	}

	public function getUdf11(): ?string
	{
		return $this->udf11;
	}

	public function getUdf12(): ?string
	{
		return $this->udf12;
	}

	public function getUdf13(): ?string
	{
		return $this->udf13;
	}

	public function getUdf14(): ?string
	{
		return $this->udf14;
	}

	public function getUdf15(): ?string
	{
		return $this->udf15;
	}
}
