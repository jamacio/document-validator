<?php

namespace Jamacio\DocumentValidator;

class DocumentValidator
{
    /**
     * Removes any non-digit characters from the document string.
     *
     * @param string $document
     * @return string
     */
    private static function clear(string $document): string
    {
        return preg_replace('/\D/', '', $document);
    }

    /**
     * Checks if the given document is a valid CPF (11 digits).
     *
     * @param string $document
     * @return bool
     */
    public static function isCPF(string $document): bool
    {
        $document = self::clear($document);
        return strlen($document) === 11 && self::validateCPF($document);
    }

    /**
     * Checks if the given document is a valid CNPJ (14 digits).
     *
     * @param string $document
     * @return bool
     */
    public static function isCNPJ(string $document): bool
    {
        $document = self::clear($document);
        return strlen($document) === 14 && self::validateCNPJ($document);
    }

    /**
     * Validates a CPF number.
     *
     * @param string $cpf
     * @return bool
     */
    public static function validateCPF(string $cpf): bool
    {
        $cpf = self::clear($cpf);

        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += $cpf[$i] * (($t + 1) - $i);
            }
            $remainder = $sum % 11;
            $digit = ($remainder < 2) ? 0 : 11 - $remainder;
            if ($cpf[$t] != $digit) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validates a CNPJ number.
     *
     * @param string $cnpj
     * @return bool
     */
    public static function validateCNPJ(string $cnpj): bool
    {
        $cnpj = self::clear($cnpj);

        if (strlen($cnpj) !== 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights1[$i];
        }
        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights2[$i];
        }
        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        return ($cnpj[12] == $digit1 && $cnpj[13] == $digit2);
    }

    /**
     * Formats a CPF number using the mask: XXX.XXX.XXX-XX
     *
     * @param string $cpf
     * @return string
     */
    public static function formatCPF(string $cpf): string
    {
        $cpf = self::clear($cpf);
        if (strlen($cpf) !== 11) {
            return $cpf;
        }
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    /**
     * Formats a CNPJ number using the mask: XX.XXX.XXX/XXXX-XX
     *
     * @param string $cnpj
     * @return string
     */
    public static function formatCNPJ(string $cnpj): string
    {
        $cnpj = self::clear($cnpj);
        if (strlen($cnpj) !== 14) {
            return $cnpj;
        }
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }

    /**
     * Validates the document, automatically determining if it is a CPF or CNPJ.
     *
     * @param string $document
     * @return bool
     */
    public static function validateDocument(string $document): bool
    {
        $document = self::clear($document);
        if (strlen($document) === 11) {
            return self::validateCPF($document);
        } elseif (strlen($document) === 14) {
            return self::validateCNPJ($document);
        }
        return false;
    }
}
