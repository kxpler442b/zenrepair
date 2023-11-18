<?php

declare(strict_types = 1);

namespace App\Domain\Service;

use Valitron\Validator;
use Psr\Log\LoggerInterface;
use App\Domain\Enum\InputGuardEnum;

/**
 * Service class for handling input validation & sanitation
 */
final class InputGuardService
{
    private LoggerInterface $logger;
    private array $output;
    private array $errors;
    private string $rulesetPath;

    public function __construct(
        LoggerInterface $logger,
        string $rulesetPath
    ) {
        $this->logger = $logger;
        $this->output = [];
        $this->errors = [];
        $this->rulesetPath = $rulesetPath;
    }

    /**
     * Returns the validated and sanitised data.
     *
     * @return array
     */
    public function getOutput(): array
    {
        return $this->output;
    }
    
    /**
     * Return the errors array.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Process the given input data and return a validated, sanitised output.
     *
     * @param array $input
     * @param string $rulesetName
     * 
     * @return boolean
     */
    public function process(array $input, string $rulesetName): InputGuardEnum
    {
        $v = new Validator($input);
        $ruleset = $this->getRuleset($rulesetName);

        if($ruleset == null) {
            return InputGuardEnum::FAILED_ERROR;
        }
        
        $v->rules($ruleset);

        if($v->validate()) {
            $this->sanitise($input);

            return InputGuardEnum::SUCCESS;
        } else {
            $this->errors = $v->errors();

            return InputGuardEnum::FAILED_ERROR;
        }
    }

    private function sanitise(array $input): void
    {
        $output = [];

        foreach($input as $key => $value) {
            $output[$key] = $value;
        }

        $this->output = $output;
    }

    /**
     * Attempts to get the requested ruleset and return the resulting array.
     *
     * @param string $rulesetName
     * 
     * @return array|null
     */
    private function getRuleset(string $rulesetName): ?array
    {
        $file = sprintf('/%s/%s.php', $this->rulesetPath, $rulesetName);

        if(file_exists($file)) {
            $ruleset = include_once($file);
        }

        if(is_array($ruleset)) {
            return $ruleset;
        }

        return null;
    }
}