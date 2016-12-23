export class Settings {
    public defaultTitle: string = 'Trade Poster';
    public defaultBodyClass: string = 'gray-bg';
    public loginUrl: string = 'http://localhost/tradeposter/web/themes/cafe/server/login';
    public loginOutUrl: string = 'http://localhost/tradeposter/web/themes/cafe/server/logout';
    public systemloginUrl: string = 'http://localhost/tradeposter/web/themes/cafe/server/systemlogin';
    public configUrl: string = 'http://localhost/tradeposter/web/themes/cafe/server/config';
    public requestType = 'http';//http or jsonp
}