<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CnpjValidationRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Remover caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', (string) $value);

        // Verificar se o CNPJ tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verificar se todos os dígitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Validar dígitos verificadores
         // Validar dígitos verificadores
         for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public function message()
    {
        return 'O campo :attribute não é um CNPJ válido.';
    }
}
