<?php
namespace App;

use League\Csv\Reader;
use League\Csv\Stream;

class CsvReader
{
    public function read(string $content, string $delimiter = ';'): iterable
    {
        $reader = Reader::createFromString($content);
        $reader->setDelimiter($delimiter);
        $reader->setHeaderOffset(0);

        $bom = $reader->getInputBOM();

        if ($bom === Reader::BOM_UTF16_LE || $bom === Reader::BOM_UTF16_BE) {
            $reader->addStreamFilter('convert.iconv.UTF-16/UTF-8');
        }

        yield from $reader;
    }
}
