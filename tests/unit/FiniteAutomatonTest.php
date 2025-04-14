<?php

use FSM\FiniteAutomaton;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the FiniteAutomaton class.
 */
class FiniteAutomatonTest extends TestCase
{
    // Test setup method to create a FiniteAutomaton instance.
    private function createTestFSM(): FiniteAutomaton
    {
        // Configuring FSM
        // A set of states.
        $states = ['S0', 'S1', 'S2'];
        // Valid input alphabet.
        $alphabets = ['0', '1'];
        // FSM initial state
        $initialState = 'S0';
        // A set of accepting/final states.
        $finalStates = ['S0', 'S1', 'S20']; // Note: 'S20' is for testing with non-accepting state
        // Transition function
        $transition = function (string $state, string $alphabet): string {
            $transitions = [
                'S0' => ['0' => 'S0', '1' => 'S1'],
                'S1' => ['0' => 'S2', '1' => 'S0'],
                'S2' => ['0' => 'S1', '1' => 'S2'],
            ];
            return $transitions[$state][$alphabet];
        };

        $outputMap = [
            'S0' => 0,
            'S1' => 1,
            'S2' => 2,
        ];

        return new FiniteAutomaton($states, $alphabets, $initialState, $finalStates, $transition);
    }

    public function testInitialState()
    {
        $fsm = $this->createTestFSM();
        $this->assertEquals('S0', $fsm->getCurrentState());
    }

    public function testValidTransitionSequence()
    {
        $fsm = $this->createTestFSM();
        $final = $fsm->process(['1', '1', '0']); // S0 -> S1 -> S0
        $this->assertEquals('S0', $final);
    }

    public function testResetFunctionality()
    {
        $fsm = $this->createTestFSM();
        $fsm->process(['1', '0']);
        $fsm->reset();
        $this->assertEquals('S0', $fsm->getCurrentState());
    }

    public function testAcceptingState()
    {
        $fsm = $this->createTestFSM();
        $fsm->process(['1', '1']);
        $this->assertTrue($fsm->isAccepting());
    }

    public function testNonAcceptingState()
    {
        $fsm = $this->createTestFSM();
        $fsm->process(['1', '0']);
        $this->assertFalse($fsm->isAccepting());
    }

    public function testInvalidInputThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $fsm = $this->createTestFSM();
        $fsm->process(['1', 'x']);
    }
}
