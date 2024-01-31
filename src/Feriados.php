<?php

declare(strict_types=1);

namespace App;

class Feriados
{
    public static array $feriados = [
        '20240101' => '1º de janeiro: Confraternização Universal (feriado nacional);',
        '20240407' => '7 de abril: Paixão de Cristo (feriado nacional);',
        '20240421' => '21 de abril: Aniversário de Brasília (feriado local) e Tiradentes (feriado nacional);',
        '20240501' => '1º de maio: Dia Mundial do Trabalho (feriado nacional);',
        '20240907' => '7 de setembro: Independência do Brasil (feriado nacional);',
        '20241012' => '12 de outubro: Nossa Senhora Aparecida (feriado nacional);',
        '20241102' => '2 de novembro: Finados (feriado nacional);',
        '20241115' => '15 de novembro: Proclamação da República (feriado nacional);',
        '20241130' => '30 de novembro: Dia do Evangélico (feriado local);',
        '20241225' => '25 de dezembro: Natal (feriado nacional).',
        ];

    public static function verificaDiaUtil(\DateTimeImmutable $data):bool{

        //Verifica se é sábado ou domingo
        if (in_array($data->format("w"), [0,6])){
            return false;
        }

        if (in_array($data->format("Ymd"), array_keys(self::$feriados))){
            return false;
        }

        return true;
    }

}