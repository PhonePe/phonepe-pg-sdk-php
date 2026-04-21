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

class MetaInfo
{
	public $udf1;
	public $udf2;
	public $udf3;
	public $udf4;
	public $udf5;
	public $udf6;
	public $udf7;
	public $udf8;
	public $udf9;
	public $udf10;
	public $udf11;
	public $udf12;
	public $udf13;
	public $udf14;
	public $udf15;

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
	 */
	public function __construct(?string $udf1 = null, ?string $udf2 = null, ?string $udf3 = null, ?string $udf4 = null, ?string $udf5 = null, ?string $udf6 = null, ?string $udf7 = null, ?string $udf8 = null, ?string $udf9 = null, ?string $udf10 = null, ?string $udf11 = null, ?string $udf12 = null, ?string $udf13 = null, ?string $udf14 = null, ?string $udf15 = null)
	{
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