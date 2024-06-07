<?php
namespace Tests\Unit;

use App\Helpers\Ciphers;
use Illuminate\Support\Facades\Exceptions;
use Tests\TestCase;

class CipherCaeserDecryptTest extends TestCase
{
    /**
     * @test
     * @dataProvider validData
     * @return void
     */
    public function test_valid_data($validData): void
    {
        $result = Ciphers::caesar_decrypt($validData['str'], $validData['key']);

        $this->assertEquals($result, $validData['expected_result']);
    }

    /**
     * @test
     * @dataProvider invalidDataInvalidKey
     * @return void
     */
    public function test_invalid_data_invalid_key($invalidDataInvalidKey): void
    {
        $this->expectException(\TypeError::class);
        $result = Ciphers::caesar_decrypt($invalidDataInvalidKey['str'], $invalidDataInvalidKey['key']);
    }

    /**
     * @test
     * @dataProvider invalidDataMissedParameter
     * @return void
     */
    public function test_invalid_data_missed_parameter($invalidDataMissedParameter): void
    {
        $this->expectException(\ErrorException::class);
        $result = Ciphers::caesar_decrypt($invalidDataMissedParameter['str'], $invalidDataMissedParameter['key']);
    }

    public function validData()
    {
        return [
            'valid string' => [
                [
                    'str' => 'bcdef',
                    'key' => 1,
                    'expected_result' => 'abcde'
                ]
            ],
            'valid string end of alphabet' => [
                [
                    'str' => 'bcdef',
                    'key' => 3,
                    'expected_result' => 'yzabc',
                ]
            ],
            'valid string with dots and commas' => [
                [
                    'str' => 'bc, def.',
                    'key' => 1,
                    'expected_result' => 'ab, cde.'
                ]
            ],
            'valid data with numbers' => [
                [
                    'str' => 'b1c2d3e4f5',
                    'key' => 1,
                    'expected_result' => 'a1b2c3d4e5'
                ]
            ],
            'valid data with upper case' => [
                [
                    'str' => 'BcDeF',
                    'key' => 1,
                    'expected_result' => 'AbCdE'
                ]
            ],
            'empty string' => [
                [
                    'str' => '',
                    'key' => 1,
                    'expected_result' => ''
                ]
            ],
            'valid data with key bigger than 26' => [
                [
                    'str' => 'bcdef',
                    'key' => 27,
                    'expected_result' => 'abcde'
                ]
            ],
            'valid data with key 0' => [
                [
                    'str' => 'abcde',
                    'key' => 0,
                    'expected_result' => 'abcde'
                ]
            ],
            'valid data with key smaller than 0' => [
                [
                    'str' => 'zabcd',
                    'key' => -1,
                    'expected_result' => 'abcde'
                ]
            ]
        ];
    }

    public function invalidDataInvalidKey()
    {
        return [
            'invalid key' => [
                [
                    'str' => 'bcdef',
                    'key' => 'a',
                    'expected_result' => 'abcde'
                ]
            ]
        ];
    }

    public function invalidDataMissedParameter()
    {
        return [
            'missed str' => [
                [
                    'key' => 1,
                    'expected_result' => 'bcdef'
                ]
            ],
            'missed key' => [
                [
                    'str' => 'abcde',
                    'expected_result' => 'nopqr'
                ]
            ]
        ];
    }

}
