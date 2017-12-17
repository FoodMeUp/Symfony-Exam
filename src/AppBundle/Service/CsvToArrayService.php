<?php

namespace AppBundle\Service;

class CsvToArrayService
{
    /**
     * Convert CSV file to PHP array.
     *
     * @param string $filename
     * @param string $delimiter
     *
     * @return array
     */
    public function convert(string $filename, string $delimiter = ';'): array
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return [];
        }

        $header = null;
        $data = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }

            fclose($handle);
        }
        return $data;
    }
}
