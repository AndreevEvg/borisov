<?php

abstract class Unit
{
    abstract function bombardStrength();

    public function getComposite()
    {
        return null;
    }
}

abstract class CompositeUnit extends Unit
{
    private $units = [];

    public function getComposite()
    {
        return $this;
    }

    protected function units()
    {
        return $this->units;
    }

    public function removeUnit(Unit $unit)
    {
        $this->units = array_udiff($this->units, array($unit), 
            function($a, $b){ return ($a === $b) ? 0 : 1; });
    }

    public function addUnit(Unit $unit)
    {
        if (in_array($unit, $this->units, true)) {
                return;
        }

        $this->units[] = $unit;
    }
}

class Archer extends Unit
{
    public function bombardStrength()
    {
        return 4;
    }
}

class LaserCannonUnit extends Unit
{
    public function bombardStrength()
    {
        return 6;
    }
}

class Army extends Unit
{
    private $units = [];

    public function bombardStrength()
    {
        $ret = 0;

        foreach ($this->units as $unit) {
                $ret += $unit->bombardStrength();
        }

        return $ret;
    }
}

$main_army = new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannonUnit());

$sub_army = new Army();
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());

$main_army->addUnit($sub_army);

echo "Атакующая сила: {$main_army->bombardStrength()}<br>";


