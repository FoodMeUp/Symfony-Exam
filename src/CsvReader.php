<?php
namespace App;

use League\Csv\Reader;

class CsvReader
{
    public function read(string $path, string $delimiter = ';'): iterable
    {
        $reader = Reader::createFromPath($path);
        $reader->setDelimiter($delimiter);
        $reader->setHeaderOffset(0);

        $bom = $reader->getInputBOM();

        if ($bom === Reader::BOM_UTF16_LE || $bom === Reader::BOM_UTF16_BE) {
            $reader->addStreamFilter('convert.iconv.UTF-16/UTF-8');
        }

        yield from $reader;
    }
}
