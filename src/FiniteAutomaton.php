<?php

namespace FSM;

use InvalidArgumentException;
use OutOfBoundsException;

/**
 * FiniteAutomaton
 *
 * A finite automaton (FA) is a 5-tuple (Q,Σ,q0,F,δ) where,
 * Q is a finite set of states;
 * Σ is a finite input alphabet;
 * q0 ∈ Q is the initial state;
 * F ⊆ Q is the set of accepting/final states; and
 * δ:Q×Σ→Q is the transition function.
 */

class FiniteAutomaton
{
    /** @var string[] List of states */
    private $states = [];

    /** @var string[] Input alphabet */
    private $alphabets = [];

    /** @var string Initial state */
    private $initialState = '';

    /** @var string[] List of accepting/final states */
    private  $finalStates = [];

    /** @var callable Transition function: function(state: string, alphabet: string): string */
    private $transition;

    /** @var string Current state after processing input */
    private $currentState = '';

    /**
     * FiniteAutomaton constructor.
     *
     * @param string[] $states        List of all states
     * @param string[] $alphabets     Valid input alphabets
     * @param string   $initialState  Starting state
     * @param string[] $finalStates   List of accepting/final states
     * @param callable $transition    Transition function (state, alphabet) => next state
     */
    public function __construct(
        array $states,
        array $alphabets,
        string $initialState,
        array $finalStates,
        callable $transition
    ) {
        $this->states = $states;
        $this->alphabets = $alphabets;
        $this->initialState = $initialState;
        $this->finalStates = $finalStates;
        $this->transition = $transition;
        $this->currentState = $initialState;
    }

    /**
     * Processes input alphabets.
     *
     * @param string[] $alphabets Sequence of input alphabets
     * @return string Final state after processing input
     * @throws InvalidArgumentException If any input alphabet is invalid
     * @throws OutOfBoundsException If a value is not exist in the valid set value
     */
    public function process(array $alphabets): string
    {
        $this->reset();

        if (!in_array($this->initialState, $this->states, true)) {
            throw new OutOfBoundsException("Invalid initialState: $this->initialState");
        }

        foreach ($alphabets as $alphabet) {
            if (!in_array($alphabet, $this->alphabets, true)) {
                throw new InvalidArgumentException("Invalid input alphabet: $alphabet");
            }
            $this->currentState = ($this->transition)($this->currentState, $alphabet);
        }

        if (!self::isAccepting()) {
            //   throw new OutOfBoundsException("Invalid final state: {$this->currentState}");
        }

        return $this->currentState;
    }

    /**
     * Resets the FSM to the initial state.
     */
    public function reset(): void
    {
        $this->currentState = $this->initialState;
    }

    /**
     * Returns the current state.
     *
     * @return string Current state
     */
    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    /**
     * Checks if the state is in an accepting state.
     *
     * @return bool True if current state is accepting
     */
    public function isAccepting(): bool
    {
        return in_array($this->currentState, $this->finalStates, true);
    }
}
