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


namespace PhonePe\payments\v2\models\request\builders;

use PhonePe\payments\v2\models\request\MetaInfo;
use PhonePe\payments\v2\models\request\StandardCheckoutPayRequest;
use PhonePe\payments\v2\standardCheckout\StandardCheckoutConstants;

class StandardCheckoutPayRequestBuilder
{

	private string $merchantOrderId;
	private int $amount;
	private string $message;
	private string $redirectUrl;

	private ?string $udf1 = null;
	private ?string $udf2 = null;
	private ?string $udf3 = null;
	private ?string $udf4 = null;
	private ?string $udf5 = null;
	private ?string $udf6 = null;
	private ?string $udf7 = null;
	private ?string $udf8 = null;
	private ?string $udf9 = null;
	private ?string $udf10 = null;
	private ?string $udf11 = null;
	private ?string $udf12 = null;
	private ?string $udf13 = null;
	private ?string $udf14 = null;
	private ?string $udf15 = null;

	/**
	 * @param string $merchantOrderId
	 * @return $this
	 */
	public function merchantOrderId($merchantOrderId): StandardCheckoutPayRequestBuilder
	{
		$this->merchantOrderId = $merchantOrderId;
		return $this;
	}

	/**
	 * @param int $amount
	 * @return $this
	 */
	public function amount($amount): StandardCheckoutPayRequestBuilder
	{
		$this->amount = $amount;
		return $this;
	}

	/**
	 * @param string $message
	 * @return $this
	 */
	public function message($message): StandardCheckoutPayRequestBuilder
	{
		$this->message = $message;
		return $this;
	}

	/**
	 * @param string $redirectUrl
	 * @return $this
	 */
	public function redirectUrl($redirectUrl): StandardCheckoutPayRequestBuilder
	{
		$this->redirectUrl = $redirectUrl;
		return $this;
	}

	public function udf1($udf1): StandardCheckoutPayRequestBuilder{
		$this->udf1 = $udf1;
		return $this;
	}

	public function udf2($udf2): StandardCheckoutPayRequestBuilder{
		$this->udf2 = $udf2;
		return $this;
	}

	public function udf3($udf3): StandardCheckoutPayRequestBuilder{
		$this->udf3 = $udf3;
		return $this;
	}

	public function udf4($udf4): StandardCheckoutPayRequestBuilder{
		$this->udf4 = $udf4;
		return $this;
	}

	public function udf5($udf5): StandardCheckoutPayRequestBuilder{
		$this->udf5 = $udf5;
		return $this;
	}

	public function udf6($udf6): StandardCheckoutPayRequestBuilder{
		$this->udf6 = $udf6;
		return $this;
	}

	public function udf7($udf7): StandardCheckoutPayRequestBuilder{
		$this->udf7 = $udf7;
		return $this;
	}

	public function udf8($udf8): StandardCheckoutPayRequestBuilder{
		$this->udf8 = $udf8;
		return $this;
	}

	public function udf9($udf9): StandardCheckoutPayRequestBuilder{
		$this->udf9 = $udf9;
		return $this;
	}

	public function udf10($udf10): StandardCheckoutPayRequestBuilder{
		$this->udf10 = $udf10;
		return $this;
	}

	public function udf11($udf11): StandardCheckoutPayRequestBuilder{
		$this->udf11 = $udf11;
		return $this;
	}

	public function udf12($udf12): StandardCheckoutPayRequestBuilder{
		$this->udf12 = $udf12;
		return $this;
	}

	public function udf13($udf13): StandardCheckoutPayRequestBuilder{
		$this->udf13 = $udf13;
		return $this;
	}

	public function udf14($udf14): StandardCheckoutPayRequestBuilder{
		$this->udf14 = $udf14;
		return $this;
	}

	public function udf15($udf15): StandardCheckoutPayRequestBuilder{
		$this->udf15 = $udf15;
		return $this;
	}

	/**
	 * @return StandardCheckoutPayRequestBuilder
	 */
	public static function builder(): StandardCheckoutPayRequestBuilder
	{
		return new StandardCheckoutPayRequestBuilder();
	}

	/**
	 * @return StandardCheckoutPayRequest
	 */
	public function build(): StandardCheckoutPayRequest
	{
		$paymentFlow = array();
		$paymentFlow["type"] = StandardCheckoutConstants::STANDARD_CHECKOUT_PAYMENT_FLOW_TYPE;
		$paymentFlow["message"] = $this->message;
		$paymentFlow["merchantUrls"]["redirectUrl"] = $this->redirectUrl;

		$metaInfo = new MetaInfo(
			$this->udf1,
			$this->udf2,
			$this->udf3,
			$this->udf4,
			$this->udf5,
			$this->udf6,
			$this->udf7,
			$this->udf8,
			$this->udf9,
			$this->udf10,
			$this->udf11,
			$this->udf12,
			$this->udf13,
			$this->udf14,
			$this->udf15
		);

		return new StandardCheckoutPayRequest(
			$this->merchantOrderId,
			$this->amount,
			$metaInfo,
			$paymentFlow
		);
	}



}