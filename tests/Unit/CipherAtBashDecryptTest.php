<?php
namespace Tests\Unit;

use App\Helpers\Ciphers;
use Illuminate\Support\Facades\Exceptions;
use Tests\TestCase;

class CipherAtBashDecryptTest extends TestCase
{
    /**
     * @test
     * @dataProvider validData
     * @return void
     */
    public function test_valid_data($validData): void
    {
        $result = Ciphers::atbash_decrypt($validData['str']);

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
        $result = Ciphers::atbash_decrypt($invalidDataMissedParameter['str']);
    }

    public function validData()
    {
        return [
            'valid string' => [
                [
                    'str' => 'zyxwv',
                    'expected_result' => 'abcde'
                ]
            ],
            'valid string end of alphabet' => [
                [
                    'str' => 'bazyx',
                    'expected_result' => 'yzabc',
                ]
            ],
            'valid string with dots and commas' => [
                [
                    'str' => 'zy, xwv.',
                    'expected_result' => 'ab, cde.'
                ]
            ],
            'valid data with numbers' => [
                [
                    'str' => 'z1y2x3w4v5',
                    'expected_result' => 'a1b2c3d4e5'
                ]
            ],
            'valid data with upper case' => [
                [
                    'str' => 'ZyXwV',
                    'expected_result' => 'AbCdE'
                ]
            ],
            'empty string' => [
                [
                    'str' => '',
                    'expected_result' => ''
                ]
            ]
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
