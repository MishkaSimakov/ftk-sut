<?php


namespace App\Achievements;


use App\Achievement;

abstract class AchievementType
{
    protected $model;

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
           'name' => $this->name(),
            'description' => $this->description,
            'icon' => $this->icon
        ]);
    }

    abstract function qualifier($point);

    public function modelKey()
    {
        return $this->model->getKey();
    }

    public function name()
    {
        if (property_exists($this, 'name')) {
            return $this->name;
        }

        return trim(preg_replace('/[A-Z]/', ' $0', class_basename($this)));
    }
}
