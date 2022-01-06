<?php
namespace nv;

use DateInterval;
use DateTime;

class NvDate
{
    public static function getDiff(string $star, string $end = 'now'):DateInterval
    {
        $date_star = new DateTime($star);
        $date_end = new DateTime($end);
        return $date_star->diff($date_end);
    }


    /**
     * Obtiene la diferencia entre dos fecha.
     * @param string $star Fecha inicial.
     * @param string $end Fecha final por default de la fecha actual
     * @return string Retorna un string con la diferencia entre las dos fecha
     * ejm. 1 años, 5 meses, 3 dias
     */
    public static function getDiffString(string $star, string $end = 'now'):string
    {
        $dff = self::getDiff($star, $end);
        
        $result_string = '';
        $result_string .= $dff->y > 0 ?  ( $dff->y == 1 ? $dff->y . " año"  : $dff->y . ' años' ) : '';
        $result_string .=  ($dff->m > 0 ?  ', '.( $dff->m == 1 ? $dff->m . " mes"  : $dff->m . ' meses' ) : '');
        $result_string .=  ($dff->d > 0 ?  ', '.( $dff->d == 1 ? $dff->d . " dia"  : $dff->d . ' dias' ) : '');
        
        $result_string = ltrim($result_string, ', ');
        
        return $result_string;
    }


    /**
     * Obtiene la diferencia entre dos fecha con horas y minutos.
     * @param string $star Fecha inicial.
     * @param string $end Fecha final por default de la fecha actual
     * @return string Retorna un string con la diferencia entre las dos fecha
     * ejm. 1 años, 5 meses, 3 dias, 3 horas, 20 minutos.
     */
    public static function getDiffFullString(string $star, string $end = 'now'):string
    {
        $dff = self::getDiff($star, $end);

        $d = '';
    
        $d .= $dff->y > 0 ?  ( $dff->y == 1 ? $dff->y . " año"  : $dff->y . ' años' ) : '';
        $d .=  ($dff->m > 0 ?  ', '.( $dff->m == 1 ? $dff->m . " mes"  : $dff->m . ' meses' ) : '');
        $d .=  ($dff->d > 0 ?  ', '.( $dff->d == 1 ? $dff->d . " dia"  : $dff->d . ' dias' ) : '');
        $d .=  ($dff->h > 0 ?  ', '.( $dff->h == 1 ? $dff->h . " hora"  : $dff->h . ' horas' ) : '');
        $d .=  ($dff->i > 0 ?  ', '.( $dff->i == 1 ? $dff->i . " minuto"  : $dff->i . ' minutos' ) : '');
    
        $d = ltrim($d, ', ');
    
        return $d;
    }
}