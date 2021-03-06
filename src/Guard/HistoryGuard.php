<?php

namespace BalnoWorkflow\Guard;

use BalnoWorkflow\ContextInterface;
use BalnoWorkflow\Exception\InvalidHistoryGuardConditionException;
use BalnoWorkflow\Exception\InvalidRunnableExpressionException;

class HistoryGuard
{
    use StatusHistoryAware;

    /**
     * @param ContextInterface $context
     * @param $condition
     * @param $countEntries
     * @return bool
     * @throws InvalidRunnableExpressionException
     */
    public function statusEntries(ContextInterface $context, $condition, $countEntries)
    {
        return $this->processCondition($condition, $this->getStatusSets($context, false), (int) $countEntries);
    }

    /**
     * @param ContextInterface $context
     * @param $condition
     * @param $countEntries
     * @return bool
     * @throws InvalidRunnableExpressionException
     */
    public function statusReentries(ContextInterface $context, $condition, $countEntries)
    {
        return $this->processCondition($condition, $this->getStatusSets($context, true) - 1, (int) $countEntries);
    }

    /**
     * @param string $condition
     * @param mixed $leftValue
     * @param mixed $rightValue
     * @return bool
     * @throws InvalidRunnableExpressionException
     */
    protected function processCondition($condition, $leftValue, $rightValue)
    {
        switch ($condition) {
            case '=':
            case '==':
                return $leftValue == $rightValue;
            case '>':
                return $leftValue > $rightValue;
            case '>=':
                return $leftValue >= $rightValue;
            case '<':
                return $leftValue < $rightValue;
            case '<=':
                return $leftValue <= $rightValue;
            case '!=':
                return $leftValue != $rightValue;
            default:
                throw new InvalidHistoryGuardConditionException($condition);
        }
    }
}
