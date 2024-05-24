<?php


declare(strict_types=1);


namespace App\Utilities;

use App\Enum\DeleteStatus;



class DeleteMessage
{
    private int $deletedStatus;
    private string $entityName;

    public function __construct(int $deletedStatus, string $entityName)
    {
        $this->deletedStatus = $deletedStatus;
        $this->entityName = $entityName;
    }

    public function format(): string
    {
        switch ($this->deletedStatus) {
            case DeleteStatus::SOFT_DELETE->value:
                return sprintf('%s has been moved to trash', $this->entityName);

            case DeleteStatus::HARD_DELETE->value:
                return sprintf('%s has been permanently deleted', $this->entityName);

            case DeleteStatus::NOT_DELETED->value:
                return sprintf('%s has been restored', $this->entityName);
            
            case DeleteStatus::PARMANENT_DELETE->value:
                return sprintf('%s has been parmanently deleted', $this->entityName);

            default:
                return sprintf('No delete action happened for '.$this->deletedStatus);
        }
    }
    
}