<?php declare(strict_types=1);

namespace App\Actions;

class ApplicationHealthCheckAction
{
    private array $validApplications;

    /**
     * ApplicationHealthCheckAction constructor.
     * @param array $validApplications
     */
    public function __construct(array $validApplications)
    {
        $this->validApplications = $validApplications;
    }

    /**
     * @param string $appName
     * @return bool
     */
    public function confirm(string $appName) : bool
    {
        return in_array($appName, $this->validApplications);
    }
}