<?php
namespace Tests\Unit;

use App\Helpers\Ciphers;
use Illuminate\Support\Facades\Exceptions;
use Tests\TestCase;

class CipherCaeserEncryptTest extends TestCase
{
    /**
     * @test
     * @dataProvider validData
     * @return void
     */
    public function test_valid_data($validData): void
    {
        $result = Ciphers::caesar_encrypt($validData['str'], $validData['key']);

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
        $result = Ciphers::caesar_encrypt($invalidDataInvalidKey['str'], $invalidDataInvalidKey['key']);
    }

    /**
     * @test
     * @dataProvider invalidDataMissedParameter
     * @return void
     */
    public function test_invalid_data_missed_parameter($invalidDataMissedParameter): void
    {
        $this->expectException(\ErrorException::class);
        $result = Ciphers::caesar_encrypt($invalidDataMissedParameter['str'], $invalidDataMissedParameter['key']);
    }

    public function validData()
    {
        return [
            'valid string' => [
                [
                    'str' => 'abcde',
                    'key' => 1,
                    'expected_result' => 'bcdef'
                ]
            ],
            'valid string end of alphabet' => [
                [
                    'str' => 'yzabc',
                    'key' => 3,
                    'expected_result' => 'bcdef'
                ]
            ],
            'valid string with dots and commas' => [
                [
                    'str' => 'ab, cde.',
                    'key' => 1,
                    'expected_result' => 'bc, def.'
                ]
            ],
            'valid data with numbers' => [
                [
                    'str' => 'a1b2c3d4e5',
                    'key' => 1,
                    'expected_result' => 'b1c2d3e4f5'
                ]
            ],
            'valid data with upper case' => [
                [
                    'str' => 'AbCdE',
                    'key' => 1,
                    'expected_result' => 'BcDeF'
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
                    'str' => 'abcde',
                    'key' => 27,
                    'expected_result' => 'bcdef'
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
                    'str' => 'abcde',
                    'key' => -1,
                    'expected_result' => 'zabcd'
                ]
            ]
        ];
    }

    public function invalidDataInvalidKey()
    {
        return [
            'invalid key' => [
                [
                    'str' => 'abcde',
                    'key' => 'a',
                    'expected_result' => 'bcdef'
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
