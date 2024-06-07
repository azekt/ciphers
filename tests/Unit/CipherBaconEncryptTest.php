<?php
namespace Tests\Unit;

use App\Helpers\Ciphers;
use Illuminate\Support\Facades\Exceptions;
use Tests\TestCase;

class CipherBaconEncryptTest extends TestCase
{
    /**
     * @test
     * @dataProvider validData
     * @return void
     */
    public function test_valid_data($validData): void
    {
        $result = Ciphers::bacon_encrypt($validData['str']);

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
        $result = Ciphers::bacon_encrypt($invalidDataMissedParameter['str']);
    }

    public function validData()
    {
        return [
            'valid string' => [
                [
                    'str' => 'abcde',
                    'expected_result' => 'aaaaaaaaabaaabaaaabbaabaa'
                ]
            ],
            'valid string end of alphabet' => [
                [
                    'str' => 'yzabc',
                    'expected_result' => 'bbaaabbaabaaaaaaaaabaaaba'
                ]
            ],
            'valid string with dots and commas' => [
                [
                    'str' => 'ab, cde.',
                    'expected_result' => 'aaaaaaaaab, aaabaaaabbaabaa.'
                ]
            ],
            'valid data with numbers' => [
                [
                    'str' => 'a1b2c3d4e5',
                    'expected_result' => 'aaaaa1aaaab2aaaba3aaabb4aabaa5'
                ]
            ],
            'valid data with upper case' => [
                [
                    'str' => 'AbCdE',
                    'expected_result' => 'aaaaaaaaabaaabaaaabbaabaa'
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
                    'expected_result' => 'aaaaaaaaabaaabaaaabbaabaa'
                ]
            ]
        ];
    }

}
