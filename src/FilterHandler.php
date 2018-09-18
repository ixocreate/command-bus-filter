<?php
/**
 * kiwi-suite/command-bus-validation (https://github.com/kiwi-suite/command-bus-validation)
 *
 * @package kiwi-suite/command-bus-validation
 * @link https://github.com/kiwi-suite/command-bus-validation
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuite\CommandBusFilter;

use KiwiSuite\Contract\CommandBus\CommandInterface;
use KiwiSuite\Contract\CommandBus\DispatchInterface;
use KiwiSuite\Contract\CommandBus\HandlerInterface;
use KiwiSuite\Contract\CommandBus\ResultInterface;
use KiwiSuite\Filter\Filter;

final class FilterHandler implements HandlerInterface
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * FilterHandler constructor.
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param CommandInterface $command
     * @param DispatchInterface $dispatcher
     * @throws \Exception
     * @return ResultInterface
     */
    public function handle(CommandInterface $command, DispatchInterface $dispatcher): ResultInterface
    {
        if (!$this->filter->supports($command)) {
            return $dispatcher->dispatch($command);
        }

        return $dispatcher->dispatch($this->filter->filter($command));
    }
}
