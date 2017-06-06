if [ ! -d "/home/wwwsrc" ]; then
    mkdir /home/wwwsrc
fi

if [ ! -d "/home/wwwsrc/project1240" ]; then
    svn checkout https://github.com/Ltre/FreeLancerProjects/trunk/project1240  /home/wwwsrc/project1240
else
    cd /home/wwwsrc/project1240
    svn update
fi


if [ ! -d "/home/wwwroot/project1.yooo.moe" ]; then
    mkdir /home/wwwroot/project1.yooo.moe
fi
mv /home/wwwroot/project1.yooo.moe /home/wwwroot/project1.yooo.moe.trash
cp /home/wwwsrc/project1240/frontend -r /home/wwwroot/project1.yooo.moe
rm -f -r /home/wwwroot/project1.yooo.moe.trash
cd /home/wwwroot/project1.yooo.moe


if [ ! -d "/home/wwwroot/project1-log.yooo.moe" ]; then
    mkdir /home/wwwroot/project1-log.yooo.moe
fi
mv /home/wwwroot/project1-log.yooo.moe /home/wwwroot/project1-log.yooo.moe.trash
cp /home/wwwsrc/project1240/backend -r /home/wwwroot/project1-log.yooo.moe
chmod -R 767 /home/wwwroot/project1-log.yooo.moe/protected/data
rm -f -r /home/wwwroot/project1-log.yooo.moe.trash
cd /home/wwwroot/project1-log.yooo.moe


