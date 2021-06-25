<?php


namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Builder;

trait Checkable
{
    abstract protected function getCheckedStateEnum();
    abstract protected function getUncheckedStateEnum();

    public function check()
    {
        $isFirstTimeChecked = is_null($this->checked_at);

        $this->update([
            'type' => $this->getCheckedStateEnum(),
            'checked_at' => now()
        ]);

        $this->checked($isFirstTimeChecked);
    }

    protected function checkedEvent(bool $isFirstTimeChecked)
    {
        //
    }

    public function scopeChecked(Builder $builder): Builder
    {
        return $builder->where('type', $this->getCheckedStateEnum());
    }

    public function scopeUnchecked(Builder $builder): Builder
    {
        return $builder->where('type', $this->getUncheckedStateEnum());
    }
}
