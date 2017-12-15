<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 12/11/17
 * Time: 21:56
 *
 * @category   Symfony-Exam
 *
 * @package    AppBundle
 *
 * @subpackage AppBundle\Interfaces
 *
 * @author     Alexandre Vinet <contact@alexandrevinet.fr>
 */

namespace AppBundle\Interfaces;

use League\Csv\Reader;

/**
 * Interface FileLoaderInterface
 */
interface FileLoaderInterface
{
    /**
     * Load a csv file.
     *
     * @param Reader $reader
     *
     * @return void
     */
    public function load(Reader $reader): void;
}
