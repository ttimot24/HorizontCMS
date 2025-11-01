<?php

namespace App\Model\Trait;
 
trait IsActive {

    public function activate(): void {
        $this->active = 1;
    }

    public function deactivate(): void {
        $this->active = 0;
    }

    public function isActive(): bool {
        return $this->active > 0;
    }

    public function isInactive(): bool {
        return $this->active == null || $this->active == 0;
    }

    public function scopeActive($query){
        return $query->where('active', '>', 0);
    }

    public function scopeInActive($query){
        return $query->where('active', 0);
    }

}