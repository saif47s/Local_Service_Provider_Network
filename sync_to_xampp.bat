@echo off
echo Syncing project to XAMPP...
set "SOURCE=D:\usb\home-Services-Project"
set "DEST=C:\xampp\htdocs\home-Services-Project"

echo Source: %SOURCE%
echo Destination: %DEST%

xcopy "%SOURCE%" "%DEST%" /E /H /C /I /Y /D /EXCLUDE:exclude_list.txt

echo Sync Complete!
pause
