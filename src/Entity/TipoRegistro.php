<?php

namespace App\Entity;

enum TipoRegistro: string
{
    case INSERCAO='Inserção';
    case ATUALIZACAO='Atualização';

}