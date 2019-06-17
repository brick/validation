<?php

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\GtinValidator;

/**
 * Unit tests for the IMEI number validator.
 */
class GtinValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerGtinValidator
     */
    public function testGtinValidator(string $input, array $output) : void
    {
        $validator = new GtinValidator();

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerGtinValidator() : array
    {
        return [
            // Lengths

            ['', ['validator.gtin.invalid']],
            ['0', ['validator.gtin.invalid']],
            ['00', ['validator.gtin.invalid']],
            ['000', ['validator.gtin.invalid']],
            ['0000', ['validator.gtin.invalid']],
            ['00000', ['validator.gtin.invalid']],
            ['000000', ['validator.gtin.invalid']],
            ['0000000', ['validator.gtin.invalid']],
            ['00000000', []], // GTIN-8
            ['000000000', ['validator.gtin.invalid']],
            ['0000000000', ['validator.gtin.invalid']],
            ['00000000000', ['validator.gtin.invalid']],
            ['000000000000', []], // GTIN-12
            ['0000000000000', []], // GTIN-13
            ['00000000000000', []], // GTIN-14
            ['000000000000000', ['validator.gtin.invalid']],
            ['0000000000000000', ['validator.gtin.invalid']],

            [' 00000000', ['validator.gtin.invalid']],
            ['00000000 ', ['validator.gtin.invalid']],

            // GTIN-8

            ['91847348', []],
            ['18274622', []],
            ['85734197', []],
            ['71428956', []],
            ['33381954', []],
            ['22350183', []],
            ['40190006', []],
            ['51955557', []],
            ['69841934', []],

            ['91847347', ['validator.gtin.invalid']],
            ['18274623', ['validator.gtin.invalid']],
            ['85734198', ['validator.gtin.invalid']],
            ['71428955', ['validator.gtin.invalid']],
            ['33381955', ['validator.gtin.invalid']],
            ['22350182', ['validator.gtin.invalid']],
            ['40190007', ['validator.gtin.invalid']],
            ['51955558', ['validator.gtin.invalid']],
            ['69841933', ['validator.gtin.invalid']],

            // GTIN-12

            ['894944232487', []],
            ['279463485727', []],
            ['722150611492', []],
            ['758352691406', []],
            ['667428902615', []],
            ['337490200376', []],
            ['214227004882', []],
            ['917366122119', []],
            ['219124020904', []],
            ['829929853555', []],

            ['794944232487', ['validator.gtin.invalid']],
            ['269463485727', ['validator.gtin.invalid']],
            ['721150611492', ['validator.gtin.invalid']],
            ['758252691406', ['validator.gtin.invalid']],
            ['667418902615', ['validator.gtin.invalid']],
            ['337499200376', ['validator.gtin.invalid']],
            ['214227904882', ['validator.gtin.invalid']],
            ['917366112119', ['validator.gtin.invalid']],
            ['219124029904', ['validator.gtin.invalid']],
            ['829929853455', ['validator.gtin.invalid']],

            // GTIN-13

            ['7265560957932', []],
            ['0913414629661', []],
            ['8291038867624', []],
            ['9660290002811', []],
            ['4768493704718', []],
            ['5555599878219', []],
            ['0314003517398', []],
            ['0406074713387', []],
            ['0667891176681', []],
            ['2359570190351', []],

            ['8265560957932', ['validator.gtin.invalid']],
            ['0013414629661', ['validator.gtin.invalid']],
            ['8201038867624', ['validator.gtin.invalid']],
            ['9661290002811', ['validator.gtin.invalid']],
            ['4768593704718', ['validator.gtin.invalid']],
            ['5555509878219', ['validator.gtin.invalid']],
            ['0314004517398', ['validator.gtin.invalid']],
            ['0406074813387', ['validator.gtin.invalid']],
            ['0667891186681', ['validator.gtin.invalid']],
            ['2359570191351', ['validator.gtin.invalid']],

            // GTIN-14

            ['55440591751163', []],
            ['63470004317449', []],
            ['02434132437942', []],
            ['49566968947294', []],
            ['88792940668881', []],
            ['87491318630406', []],
            ['17853196202099', []],
            ['50044159791049', []],
            ['55160020837199', []],
            ['12776203865726', []],

            ['45440591751163', ['validator.gtin.invalid']],
            ['73470004317449', ['validator.gtin.invalid']],
            ['92434132437942', ['validator.gtin.invalid']],
            ['59566968947294', ['validator.gtin.invalid']],
            ['78792940668881', ['validator.gtin.invalid']],
            ['97491318630406', ['validator.gtin.invalid']],
            ['07853196202099', ['validator.gtin.invalid']],
            ['60044159791049', ['validator.gtin.invalid']],
            ['45160020837199', ['validator.gtin.invalid']],
            ['22776203865726', ['validator.gtin.invalid']],
        ];
    }
}
