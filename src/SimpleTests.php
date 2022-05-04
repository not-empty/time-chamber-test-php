<?php

namespace Tests1Doc;

class SimpleTests
{
    public function soma(
        int $valor1,
        int $valor2
    ): int {
        return $valor1 + $valor2;
    }

    public function multiplicacao(
        int $valor1,
        int $valor2
    ): int {
        if ($valor1 === 0) {
            return 0;
        }

        if ($valor2 === 0) {
            return 0;
        }

        return $valor1 * $valor2;
    }

    public function divisao(
        int $valor1,
        int $valor2
    ): int {
        return $valor1 / $valor2;
    }
}
