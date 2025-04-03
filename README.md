# Document Validator

Document Validator is a PHP library designed for validating and formatting Brazilian CPF and CNPJ numbers. It offers easy-to-use static methods to verify the correctness of these documents using the official algorithms, as well as to apply standard masks for displaying them.

## Features

- **CPF Validation:** Validates Brazilian CPF numbers (11 digits) using the official algorithm.
- **CNPJ Validation:** Validates Brazilian CNPJ numbers (14 digits) using the official algorithm.
- **Document Identification:** Automatically determines if the provided number is a CPF or CNPJ based on its digit count.
- **Formatting:** Applies standard masks:
  - **CPF Format:** `XXX.XXX.XXX-XX`
  - **CNPJ Format:** `XX.XXX.XXX/XXXX-XX`

## Requirements

- PHP 7.2 or higher
- Composer

## Installation

Install Document Validator via Composer by running the following command in your terminal:

```bash
composer require jamacio/document-validator
```

## Usage

Ensure Composer's autoloader is included in your project.

```php
require __DIR__ . '/vendor/autoload.php';
```

> **Note:** If you are using a CMS or framework (e.g., Laravel, Symfony), this step is usually not necessary as the autoloader is already included.

Then, use the DocumentValidator class as follows:

```bash
<?php

use Jamacio\DocumentValidator\DocumentValidator;

// Example for CPF:
$cpf = "123.456.789-09";
if (DocumentValidator::isCPF($cpf)) {
    echo "Formatted CPF: " . DocumentValidator::formatCPF($cpf) . "\n";
    echo "CPF is " . (DocumentValidator::validateCPF($cpf) ? "valid" : "invalid") . "\n";
}

// Example for CNPJ:
$cnpj = "12.345.678/0001-95";
if (DocumentValidator::isCNPJ($cnpj)) {
    echo "Formatted CNPJ: " . DocumentValidator::formatCNPJ($cnpj) . "\n";
    echo "CNPJ is " . (DocumentValidator::validateCNPJ($cnpj) ? "valid" : "invalid") . "\n";
}

// Generic document validation:
$document = "12345678909";
echo "Document " . $document . " is " . (DocumentValidator::validateDocument($document) ? "valid" : "invalid") . "\n";
```

By including the Composer autoloader, the class will be available throughout your project without the need for manual file inclusion.
