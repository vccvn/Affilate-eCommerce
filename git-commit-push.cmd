@echo off
set /p message="Enter Message: "
git add .
git commit -a -m "%message%"
git pull --rebase origin dev
git merge
git push
set /p e="Press Enter to Exit... "