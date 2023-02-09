@echo off
cls

SET /A PORT=9980
IF "%~1" == "" skipset
SET /A PORT=%1
:skipset
SET PHP_COMMAND=php
SET PROJECT=%~dp0

%PHP_COMMAND% -S localhost:%PORT% -t %PROJECT%
