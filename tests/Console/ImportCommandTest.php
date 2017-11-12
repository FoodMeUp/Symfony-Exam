<?php
namespace App\Console;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\CsvReader;
use App\Entity\IngredientFamily;
use App\Repository\IngredientFamilyRepository;

class ImportCommandTest extends TestCase
{
    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessageRegExp /^Could not open file .+? \(reason : .*?No such file or directory\)$/
     */
    public function testNotValidContent()
    {
        $repo = $this->prophesize(IngredientFamilyRepository::class);
        $repo->save(Argument::type(IngredientFamily::class))->shouldNotBeCalled();

        $reader = $this->prophesize(CsvReader::class);
        $reader->read(Argument::any())->shouldNotBeCalled();

        $command = new ImportCommand($reader->reveal(), $repo->reveal());

        $tester = new CommandTester($command);
        $tester->execute(['file' => __DIR__ . '/foo']);
    }

    public function testValidImport()
    {
        $file = tempnam(sys_get_temp_dir(), 'test_import');
        file_put_contents($file, 'foo');

        $reader = $this->prophesize(CsvReader::class);
        $reader
            ->read('foo', ';')
            ->willReturn(
                [
                    [
                        'ORIGGPCD' => 'foo',
                        'ORIGGPFR' => 'bar',
                        'ORIGFDCD' => 'baz',
                        'ORIGFDNM' => 'qux'
                    ],

                    [
                        'ORIGGPCD' => 'foo',
                        'ORIGGPFR' => 'bar',
                        'ORIGFDCD' => 'baaz',
                        'ORIGFDNM' => 'quux'
                    ],

                    [
                        'ORIGGPCD' => 'foo2',
                        'ORIGGPFR' => 'bar2',
                        'ORIGFDCD' => 'baaz2',
                        'ORIGFDNM' => 'quux2'
                    ],
                ]
            )->shouldBeCalled();

        $repo = $this->prophesize(IngredientFamilyRepository::class);
        $repo->save(Argument::type(IngredientFamily::class))->shouldBeCalled();

        $command = new ImportCommand($reader->reveal(), $repo->reveal());

        $tester = new CommandTester($command);
        $tester->execute(['file' => $file]);
    }
}
