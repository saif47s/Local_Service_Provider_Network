@echo off
copy /Y "e:\githubprojects\BCA-home-Services-Project-master\BCA-home-Services-Project-master\includes\header.php" "C:\xampp\htdocs\hs\includes\header.php"
xcopy /Y /S "e:\githubprojects\BCA-home-Services-Project-master\BCA-home-Services-Project-master\admin\assets\include\admin_header.php" "C:\xampp\htdocs\hs\admin\assets\include\admin_header.php*"
echo Sync Complete
