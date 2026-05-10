@echo off
echo Syncing project to XAMPP...
set "SOURCE=e:\android\BCA-home-Services-Project-master"
set "DEST=C:\xampp\htdocs\BCA-home-Services-Project-master"

echo Source: %SOURCE%
echo Destination: %DEST%

xcopy "%SOURCE%" "%DEST%" /E /H /C /I /Y /D /EXCLUDE:exclude_list.txt

echo Sync Complete!
pause
