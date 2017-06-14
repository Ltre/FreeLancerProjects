if [ ! -d "/home/wwwsrc" ]; then
    mkdir /home/wwwsrc
fi

if [ ! -d "/home/wwwsrc/project-2nd" ]; then
    svn checkout https://github.com/Ltre/FreeLancerProjects/trunk/project-2nd  /home/wwwsrc/project-2nd
else
    cd /home/wwwsrc/project-2nd
    svn update
fi


if [ ! -d "/home/wwwroot/project2.yooo.moe" ]; then
    mkdir /home/wwwroot/project2.yooo.moe
fi
mv /home/wwwroot/project2.yooo.moe /home/wwwroot/project2.yooo.moe.trash
cp /home/wwwsrc/project-2nd/frontend -r /home/wwwroot/project2.yooo.moe
rm -f -r /home/wwwroot/project2.yooo.moe.trash
cd /home/wwwroot/project2.yooo.moe


if [ ! -d "/home/wwwroot/project2-log.yooo.moe" ]; then
    mkdir /home/wwwroot/project2-log.yooo.moe
fi
mv /home/wwwroot/project2-log.yooo.moe /home/wwwroot/project2-log.yooo.moe.trash
cp /home/wwwsrc/project-2nd/backend -r /home/wwwroot/project2-log.yooo.moe
chmod -R 767 /home/wwwroot/project2-log.yooo.moe/protected/data
rm -f -r /home/wwwroot/project2-log.yooo.moe.trash
cd /home/wwwroot/project2-log.yooo.moe


