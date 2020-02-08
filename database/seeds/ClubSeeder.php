<?php

use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->clubs() as $club => $description) {
            factory(\App\Club::class)->create(['name' => $club, 'description' => $description]);
        }
    }

    protected function clubs(): array
    {
        return [
            'Робототехника' => 'Здесь можно собирать роботов и т.д.',
            'Электроника' => 'Ничего толком не знаю, но раз люди ходят, то там весело :)',
            'Web-программирование' => 'Не будь этого кружка, не было бы и сайта, поэтому это очень хороший кружок',
            'Интеллект' => 'Участники этого кружка неплохо пишут Эрудит и играют в ЧГК, так что видимо их там хорошо учат',
            'Рукоделие' => 'Я туда 1 год ходил и, как ветеран рукоделия, знаю, что рукоделие - это круто!'
        ];
    }
}
