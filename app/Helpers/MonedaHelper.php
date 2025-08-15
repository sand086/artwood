<?php
/**
 * MonedaHelper
 * This helper provides methods to format and unformat currency values.
 * It is used to ensure that currency values are displayed correctly in the UI
 * and stored correctly in the database.
 * It handles the conversion between formatted strings (e.g., "1,059.78")
 * and raw float values (e.g., 1059.78).
 * It is particularly useful in applications where currency values
 * need to be displayed in a user-friendly format while maintaining
 * the integrity of the data for calculations and storage.
 * @package App\Helpers
 * @version 1.0
 * @author Your Name
 * @license MIT
 * @since 2023-10-01
 * This file is part of the Artwood project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helpers;

class MonedaHelper
{
    /**
     * Formatea un valor moneda a una cadena con dos decimales y comas.
     * @param float|string $valor
     * @return string
     */
    public static function formatearMoneda(float|string $valor): string
    {
        return number_format((float) $valor, 2, '.', ',');
    }

    /**
     * Desformatea una cadena moneda a un valor float.
     * @param string $valor
     * @return float
     */
    public static function desformatearMoneda(string $valor): float
    {
        return (float) str_replace(',', '', $valor);
    }
}
