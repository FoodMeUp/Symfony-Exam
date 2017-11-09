<?php
namespace App;

use League\Csv\Reader;
use League\Csv\Stream;

class CsvReader
{
    public function read(string $content, string $delimiter = ';'): iterable
    {
        $stream = Stream::createFromString($content);

        // I'm sorry mama, but as the constructor is protected, need to hack...
        $reader = new class($stream) extends Reader {
            public function __construct(Stream $stream)
            {
                parent::__construct($stream);
            }
        };

        $reader->setDelimiter($delimiter);
        $reader->setHeaderOffset(0);

        $bom = $reader->getInputBOM();

        if ($bom === Reader::BOM_UTF16_LE || $bom === Reader::BOM_UTF16_BE) {
            $reader->addStreamFilter('convert.iconv.UTF-16/UTF-8');
        }

        yield from $reader;
    }
}
