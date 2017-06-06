if [ ! -d "/home/wwwsrc" ]; then
    mkdir /home/wwwsrc
fi

if [ ! -d "/home/wwwsrc/project1240" ]; then
	cd /home/wwwsrc
	git clone https://github.com/Ltre/project1240.git
else
	cd /home/wwwsrc/project1240
	git pull
fi


if [ ! -d "/home/wwwroot/www.fengzhang.com" ]; then
    mkdir /home/wwwroot/www.fengzhang.com
fi
mv /home/wwwroot/www.fengzhang.com /home/wwwroot/www.fengzhang.com.trash
cp /home/wwwsrc/project1240/frontend -r /home/wwwroot/www.fengzhang.com
rm -f -r /home/wwwroot/www.fengzhang.com.trash
cd /home/wwwroot/www.fengzhang.com


if [ ! -d "/home/wwwroot/log.fengzhang.com" ]; then
    mkdir /home/wwwroot/log.fengzhang.com
fi
mv /home/wwwroot/log.fengzhang.com /home/wwwroot/log.fengzhang.com.trash
cp /home/wwwsrc/project1240/backend -r /home/wwwroot/log.fengzhang.com
chmod -R 767 /home/wwwroot/log.fengzhang.com/protected/data
rm -f -r /home/wwwroot/log.fengzhang.com.trash
cd /home/wwwroot/log.fengzhang.com
