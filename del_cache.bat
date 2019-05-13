rem php artisan cache:clear
rem php artisan view:clear

del storage\framework\views\*.php
del storage\logs\*.log

set FILEMASK=*.*
set FILEPATH=storage\framework\sessions
set FILENOTDELETE=.gitignore

for /f %%i in ('dir /b /s "%FILEPATH%\%FILEMASK%"') do if /I not "%%i" == "%%~dpi%FILENOTDELETE%" del /f/q "%%i" >nul 2>nul
