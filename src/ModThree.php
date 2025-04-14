<?php

namespace FSM;

require_once 'FiniteAutomaton.php';

use InvalidArgumentException;

/**
 * modThree example Finite State Machine (FSM) implementation.
 *
 * @param string $binaryString Binary string (e.g. "1101")
 * @return int Remainder when the binary number is divided by 3 (0, 1, or 2)
 *
 * @throws InvalidArgumentException If the input contains invalid characters
 */
function modThree(string $binaryString): int
{
    // Configuring FSM
    // A set of states.
    $states = ['S0', 'S1', 'S2'];
    // Valid input alphabet.
    $alphabets = ['0', '1'];
    // FSM initial state
    $initialState = 'S0';
    // A set of accepting/final states.
    $finalStates = ['S0', 'S1', 'S2'];
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

    // Instantiate a FSM with configuration
    $fa = new FiniteAutomaton($states, $alphabets, $initialState, $finalStates, $transition);
    $finalState = $fa->process(str_split($binaryString));

    return $outputMap[$finalState];
}

echo '=== modThree FSM Demo Start ===';
echo 'Input 1101 Ouput: ' . modThree('1101') . PHP_EOL; // 1
echo 'Input 1111 Ouput: ' . modThree('1110') . PHP_EOL; // 2
echo 'Input 1111 Ouput: ' . modThree('1111') . PHP_EOL; // 0
echo 'Input 110  Ouput: ' . modThree('110') . PHP_EOL; // 0
echo 'Input 1010 Ouput: ' . modThree('1010') . PHP_EOL; // 1
echo '=== modThree FSM Demo End ===';
