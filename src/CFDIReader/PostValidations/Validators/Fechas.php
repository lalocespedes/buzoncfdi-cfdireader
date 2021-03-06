<?php

namespace CFDIReader\PostValidations\Validators;

use CFDIReader\CFDIReader;
use CFDIReader\PostValidations\Issues;

class Fechas extends AbstractValidator
{
    public function validate(CFDIReader $cfdi, Issues $issues)
    {
        // setup the AbstractValidator Helper class
        $this->setup($cfdi, $issues);
        // do the validation process
        $maxdate = time();
        $document = strtotime($this->comprobante["fecha"]);
        $comprobante = strtotime($this->comprobante->complemento->timbreFiscalDigital["fechaTimbrado"]);
        if ($document > $maxdate) {
            $this->errors->add('La fecha del documento es mayor a la fecha actual');
        }
        if ($document > $comprobante) {
            $this->errors->add('La fecha del documento es mayor a la fecha del timbrado');
        }
        if ($comprobante - $document > 259200) {
            $this->errors->add('La fecha fecha del timbrado excedió las 72 horas de la fecha del documento');
        }
    }
}
