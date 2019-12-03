#!/bin/bash

nohup php /data/AxBuild/YjtecMakePanoProd/index.php worker > YjtecMakePanoProd.log &
nohup php /data/AxBuild/YjtecMakePanoProd/index.php notify > YjtecMakePanoProd.log &