<?php


use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\api\Validation;

/**
 * @covers Granal1\RestfulPhp\api\Validation
 */
final class ValidationTest extends TestCase
{
    public function testValidationIsGoingCorrectly(): void
    {
        $data = [
            'id' => 2,
            'key' => 'value'
        ];
        $ruleName = 'rulesForTests';
        $validation = new Validation();

        $this->assertEquals(true, $validation->check($data, $ruleName));
    }


    public function testValidationFailsDueToTheAbsenceOfTheRequiredParameter(): void
    {
        $data = [
            'key' => 'value'
        ];
        $ruleName = 'rulesForTests';
        $validation = new Validation();

        $this->expectExceptionMessage('id - required; ');
        $validation->check($data, $ruleName);
    }


    public function testValidationFailsDueToTheParameterIsWrong(): void
    {
        $data = [
            'id' => 2,
            'phone' => 'wrong phone numder'
        ];
        $ruleName = 'rulesForTests';
        $validation = new Validation();

        $this->expectExceptionMessage('phone=wrong phone numder - uncorrect; ');
        $validation->check($data, $ruleName);
    }
}
