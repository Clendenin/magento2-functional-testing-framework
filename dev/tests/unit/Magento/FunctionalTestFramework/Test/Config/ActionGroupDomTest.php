<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Tests\unit\Magento\FunctionalTestFramework\Test\Config;

use Magento\FunctionalTestingFramework\Exceptions\Collector\ExceptionCollector;
use Magento\FunctionalTestingFramework\Config\Dom\ValidationException;
use Magento\FunctionalTestingFramework\Test\Config\ActionGroupDom;
use Magento\FunctionalTestingFramework\Util\MagentoTestCase;

class ActionGroupDomTest extends MagentoTestCase
{
    /**
     * Test Action Group duplicate step key validation
     */
    public function testActionGroupDomStepKeyValidation()
    {
        $sampleXml = "<actionGroups>
            <actionGroup name=\"actionGroupWithoutArguments\">
                <wait time=\"1\" stepKey=\"waitForNothing\" />
                <wait time=\"2\" stepKey=\"waitForNothing\" />
            </actionGroup>
         </actionGroups>";

        $exceptionCollector = new ExceptionCollector();
        $actionDom = new ActionGroupDom($sampleXml, 'dupeStepKeyActionGroup.xml', $exceptionCollector);

        $this->expectException(\Exception::class);
        $exceptionCollector->throwException();
    }

    /**
     * Test Action Group invalid XML
     */
    public function testActionGroupDomInvalidXmlValidation()
    {
        $sampleXml = "<actionGroups>
            <actionGroup name=\"actionGroupWithoutArguments\">
                <wait>
            </actionGroup>
         </actionGroups>";

        $exceptionCollector = new ExceptionCollector();
        $this->expectException(ValidationException::class);
        new ActionGroupDom($sampleXml, 'bad.xml', $exceptionCollector);
    }
}
