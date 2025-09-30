<?php

namespace Modules\Employees\Models\Traits;


use Modules\Employees\Models\EmployeeProfile;

trait HasEmployeeProfile
{
    /**
     * Get the employee profile associated with the user.
     */
    public function employeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    /**
     * Check if the user has an employee profile.
     */
    public function isEmployee(): bool
    {
        return (bool) $this->employeeProfile;
    }

    /**
     * Scope a query to only include users that are employees.
     */
    public function scopeEmployees($query)
    {
        return $query->has('employeeProfile');
    }
}
