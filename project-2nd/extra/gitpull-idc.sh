if [ ! -d "/home/wwwsrc" ]; then
    mkdir /home/wwwsrc
fi

if [ ! -d "/home/wwwsrc/project-2nd" ]; then
    svn checkout https://github.com/Ltre/FreeLancerProjects/trunk/project-2nd  /home/wwwsrc/project-2nd
else
    cd /home/wwwsrc/project-2nd
    svn update
fi


if [ ! -d "/home/wwwroot/www.abc.com" ]; then
    mkdir /home/wwwroot/www.abc.com
fi
mv /home/wwwroot/www.abc.com /home/wwwroot/www.abc.com.trash
cp /home/wwwsrc/project-2nd/frontend -r /home/wwwroot/www.abc.com
rm -f -r /home/wwwroot/www.abc.com.trash
cd /home/wwwroot/www.abc.com


if [ ! -d "/home/wwwroot/log.abc.com" ]; then
    mkdir /home/wwwroot/log.abc.com
fi
mv /home/wwwroot/log.abc.com /home/wwwroot/log.abc.com.trash
cp /home/wwwsrc/project-2nd/backend -r /home/wwwroot/log.abc.com
chmod -R 767 /home/wwwroot/log.abc.com/protected/data
rm -f -r /home/wwwroot/log.abc.com.trash
cd /home/wwwroot/log.abc.com
