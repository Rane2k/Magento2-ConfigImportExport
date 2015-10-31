<?php
/**
 * Copyright © 2015 Rouven Alexander Rieker - All rights reserved.
 * See LICENSE.md bundled with this module for license details.
 */
namespace Semaio\ConfigImportExport\Model\File\Reader;

/**
 * Interface ReaderInterface
 *
 * @package Semaio\ConfigImportExport\Model\File\Reader
 */
interface ReaderInterface
{
    /**
     * @param string $fileName
     * @return array
     */
    public function parse($fileName);
}