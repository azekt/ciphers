<?php
namespace Tests\Unit;

use App\Helpers\Ciphers;
use Illuminate\Support\Facades\Exceptions;
use Tests\TestCase;

class CipherBaconDecryptTest extends TestCase
{
    /**
     * @test
     * @dataProvider validData
     * @return void
     */
    public function test_valid_data($validData): void
    {
        $result = Ciphers::bacon_decrypt($validData['str']);

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
        $result = Ciphers::bacon_decrypt($invalidDataMissedParameter['str']);
    }

    public function validData()
    {
        return [
            'valid string' => [
                [
                    'str' => 'aaaaaaaaabaaabaaaabbaabaa',
                    'expected_result' => 'ABCDE'
                ]
            ],
            'valid string end of alphabet' => [
                [
                    'str' => 'bbaaabbaabaaaaaaaaabaaaba',
                    'expected_result' => 'YZABC'
                ]
            ],
            'valid string with dots and commas' => [
                [
                    'str' => 'aaaaaaaaab, aaabaaaabbaabaa.',
                    'expected_result' => 'AB, CDE.'
                ]
            ],
            'valid data with numbers' => [
                [
                    'str' => 'aaaaa1aaaab2aaaba3aaabb4aabaa5',
                    'expected_result' => 'A1B2C3D4E5'
                ]
            ],
            'valid data with error' => [
                [
                    'str' => 'aaaaxaaaabaaabaaaabbaabaa',
                    'expected_result' => '?BCDE',
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
                    'expected_result' => 'aaaaaaaaabaaabaaaabbaabaa'
                ]
            ]
        ];
    }

}
