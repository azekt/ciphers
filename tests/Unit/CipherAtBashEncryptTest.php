<?php
namespace Tests\Unit;

use App\Helpers\Ciphers;
use Illuminate\Support\Facades\Exceptions;
use Tests\TestCase;

class CipherAtBashEncryptTest extends TestCase
{
    /**
     * @test
     * @dataProvider validData
     * @return void
     */
    public function test_valid_data($validData): void
    {
        $result = Ciphers::atbash_encrypt($validData['str']);

        $this->assertEquals($result, $validData['expected_result']);
    }

    /**
     * @test
     * @dataProvider invalidDataMissedParameter
     * @return void
     */

    public function test_invalid_data_missed_parameter($invalidDataMissedParameter): void
    {
        $this->expectException(\ErrorException::class);
        $result = Ciphers::atbash_encrypt($invalidDataMissedParameter['str']);
    }

    public function validData()
    {
        return [
            'valid string' => [
                [
                    'str' => 'abcde',
                    'expected_result' => 'zyxwv'
                ]
            ],
            'valid string end of alphabet' => [
                [
                    'str' => 'yzabc',
                    'expected_result' => 'bazyx'
                ]
            ],
            'valid string with dots and commas' => [
                [
                    'str' => 'ab, cde.',
                    'expected_result' => 'zy, xwv.'
                ]
            ],
            'valid data with numbers' => [
                [
                    'str' => 'a1b2c3d4e5',
                    'expected_result' => 'z1y2x3w4v5'
                ]
            ],
            'valid data with upper case' => [
                [
                    'str' => 'AbCdE',
                    'expected_result' => 'ZyXwV'
                ]
            ],
            'empty string' => [
                [
                    'str' => '',
                    'expected_result' => ''
                ]
            ],
        ];
    }

    public function invalidDataMissedParameter()
    {
        return [
            'missed str' => [
                [
                    'expected_result' => 'zyxwv'
                ]
            ]
        ];
    }

}
