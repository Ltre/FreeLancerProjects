var baseDomain = (location.href.match(/^https?\:\/\/([-\w]+(\.[-\w]+)+)\/?/) || [,'']) [1];
var reportUrl = '';
switch (baseDomain) {
    case 'fengzhang.com':
    case 'www.fengzhang.com':
        reportUrl = 'http://log.fengzhang.com/report';
        break;
    case 'project1.yooo.moe':
        reportUrl = 'http://project1-log.yooo.moe/report';
        break;
    case '127.0.0.1':
        //reportUrl = 'http://project1-log.yooo.dev/report';
        reportUrl = 'http://127.0.0.1/project1240/backend/?r=log/report';
        break;
}
if (reportUrl) (new Image).src = reportUrl;
