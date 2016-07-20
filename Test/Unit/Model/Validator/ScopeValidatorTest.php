<?php
/**
 * Copyright © 2016 Rouven Alexander Rieker
 * See LICENSE.md bundled with this module for license details.
 */
namespace Semaio\ConfigImportExport\Test\Unit\Model\Validator;

use Magento\Store\Api\Data\WebsiteInterface;
use Magento\Store\Model\Website;
use Semaio\ConfigImportExport\Model\Validator\ScopeValidator;

/**
 * Class ScopeValidatorTest
 *
 * @package Semaio\ConfigImportExport\Test\Unit\Model\Validator
 */
class ScopeValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ScopeValidator
     */
    private $validator;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|WebsiteInterface
     */
    protected  $mockWebsiteOne = null;



    /**
     * Set up test class
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockWebsiteOne = $this->getMockBuilder(
            WebsiteInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCode'])
            ->getMockForAbstractClass();

        $storeManagerMock = $this->getMock('Magento\Store\Model\StoreManagerInterface');
        $storeManagerMock->expects($this->any())->method('getWebsites')->willReturn([1 => $this->mockWebsiteOne]);
        $storeManagerMock->expects($this->any())->method('getStores')->willReturn([2 => 'ABC']);

        $this->validator = new ScopeValidator($storeManagerMock);
    }

    /**
     * @test
     */
    public function validate()
    {
        $this->assertTrue($this->validator->validate('default', 0));
        $this->assertFalse($this->validator->validate('default', 1));

        $this->assertTrue($this->validator->validate('websites', 1));
        $this->assertFalse($this->validator->validate('websites', 2));

        $this->assertTrue($this->validator->validate('stores', 2));
        $this->assertFalse($this->validator->validate('stores', 3));
    }

    public function validateNonNumericWebsite()
    {
        $existingWebsiteCode = 'my-cool-website';

        $this->mockWebsiteOne ->expects($this->any())->method('getCode')
            ->will($this->returnValue($existingWebsiteCode));

        $this->assertTrue($this->validator->validate('website', $existingWebsiteCode));
        $this->assertTrue($this->validator->validate('website', 'am i real?'));
    }
}
