<?php

namespace Validation;

interface BaseValidator
{
    public function validate(): array;
    // public function toValidate(): array;
    // public function fields(): array;
}
