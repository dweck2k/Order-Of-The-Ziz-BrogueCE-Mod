@ECHO OFF
REM  OrderOfTheZiz.exe does not print output when run from a command prompt window.
REM  Use this script instead if you want to see it.
REM
REM  For example, try OrderOfTheZiz-cmd.bat --help
REM
for /F "delims=" %%a in ('OrderOfTheZiz.exe %*') do (echo %%a)
