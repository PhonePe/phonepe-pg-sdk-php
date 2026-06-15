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

class CustomerDetails implements \JsonSerializable
{
    private ?string $name;
    private ?string $email;
    private ?string $phoneNumber;

    /**
     * @param string|null $name        The full name of the customer.
     * @param string|null $email       The verified email address of the customer.
     * @param string|null $phoneNumber The mobile number of the customer.
     */
    public function __construct(?string $name = null, ?string $email = null, ?string $phoneNumber = null)
    {
       $this->name = $name;
       $this->email = $email;
       $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
       return $this->name;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
       return $this->email;
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

       if ($this->name !== null) {
          $result['name'] = $this->name;
       }

       if ($this->email !== null) {
          $result['email'] = $this->email;
       }

       if ($this->phoneNumber !== null) {
          $result['phoneNumber'] = $this->phoneNumber;
       }

       return $result;
    }
}