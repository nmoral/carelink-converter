<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes\Assistant;

use App\DTO\Diabetes\Assistant\Assistant as DTO;

class Assistant
{
    private readonly Output $output;

    private readonly Configuration $configuration;

    private readonly Input $input;

    public function __construct()
    {
        $this->output = new Output();
        $this->configuration = new Configuration();
        $this->input = new Input();
    }

    public function __invoke(array $row): ?DTO
    {
        $output = ($this->output)($row);
        $configuration = ($this->configuration)($row);
        $input = ($this->input)($row);

        return new DTO($output, $configuration, $input);
    }
}
