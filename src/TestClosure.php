<?php

namespace Tests1Doc;

class TestClosure {

    public function closureCall($type) {
        return $this->closure($type, function ($devType) {
            $dev = '';
            switch ($devType) {
                case 1:
                    $dev = 'is a backend';
                    break;

                case 2:
                    $dev = 'is a frontend';
                    break;

                default:
                    $dev = 'is a fullstack';
                    break;
            }

            return $dev;
        });
    }

    public function closureCall2($type) {
        return $this->closure($type, function ($devType) {
            $descryption = 'can be a human';

            if ($devType == 'backend') {
                $descryption = 'is a human';
            }

            if ($devType == 'frontend') {
                $descryption = 'has the hands in the grass';
            }

            if ($devType == 'fullstack') {
                $descryption = "is a human with the hands in the grass";
            }

            return $descryption;
        });
    }

    public function closure($type, $function) {
        $devType = $function($type);

        return "This programmer $devType";
    }
}