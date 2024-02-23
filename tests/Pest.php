<?php

uses(Tests\TestCase::class)
    ->beforeEach(function () { 
        ray()->newScreen($this->getName()); 
    })
    ->in('Feature');
    
uses(Tests\TestCase::class)
    ->beforeEach(function () { 
        ray()->newScreen($this->getName()); 
    })
    ->in('Unit');

uses(Tests\TestCase::class)
    ->beforeEach(function () { 
        ray()->newScreen($this->getName()); 
    })
    ->in('Integration');

