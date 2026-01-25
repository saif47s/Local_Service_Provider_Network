@echo off
echo Syncing project to XAMPP...
set "SOURCE=e:\final project\githubprojects\BCA-home-Services-Project-master\BCA-home-Services-Project-master"
set "DEST=C:\xampp\htdocs\hs"

echo Source: %SOURCE%
echo Destination: %DEST%

xcopy "%SOURCE%" "%DEST%" /E /H /C /I /Y /D /EXCLUDE:exclude_list.txt

echo Sync Complete!
pause
