var baseDomain = (location.href.match(/^https?\:\/\/([-\w]+(\.[-\w]+)+)\/?/) || [,'']) [1];
var reportUrl = '';
switch (baseDomain) {
    case 'abc.com':
    case 'www.abc.com':
        reportUrl = 'http://log.abc.com/report';
        break;
    case 'project2.yooo.moe':
        reportUrl = 'http://project2-log.yooo.moe/report';
        break;
    case '127.0.0.1':
        reportUrl = 'http://127.0.0.1/FreeLancerProjects/project-2nd/backend/?r=log/report';
        break;
}
if (reportUrl) (new Image).src = reportUrl;
