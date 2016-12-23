import { Injectable } from '@angular/core';
import { Http, Response, Jsonp } from '@angular/http';
import { Observable }     from 'rxjs/Observable';

import { Configuration } from './configuration';

declare var jQuery: any;

@Injectable()
export class Service {
    private request: any = {method: 'get', url: '', data: {}};

    constructor(private http: Http, private jsonp: Jsonp, private config: Configuration) {
        //this.r1esetParams();
    }

    public loadConfig(): void {
        this.url = this.config.configUrl;
        this.send().subscribe(
            data => {
                this.config.initConfig(data.config);
                this.config.loading = true;
            },
            error => console.log(error)
        );
    }

    public resetParams(): void {
        this.request = {method: 'get', url: '', data: {}};
    }

    private extractData(res: Response) {
        let body = res.json();
        return body || { };
    }

    private handleError (error: Response | any) {
        // In a real world app, we might use a remote logging infrastructure
        let errMsg: string;
        if (error instanceof Response) {
            const body = error.json() || '';
            const err = body.error || JSON.stringify(body);
            errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
        } else {
            errMsg = error.message ? error.message : error.toString();
        }

        return Observable.throw(errMsg);
    }

    send(): Observable<any> {
        let newUrl: string;

        if(this.method === 'post' || this.method === 'put') {
            if(this.config.requestType == 'jsonp') {
                newUrl = this.url + (this.url.indexOf('?') > -1 ? '&' : '?') + 'callback=JSONP_CALLBACK';
            } else {
                newUrl = this.url;
            }

            newUrl = newUrl + (newUrl.indexOf('?') > -1 ? '&' : '?') + jQuery.param({token: this.config.token});

            return this[this.config.requestType][this.method](newUrl, this.data)
                .map(this.extractData)
                .catch(this.handleError);
        } else {
            let newData: any;

            if(this.config.requestType == 'jsonp') {
                newData = jQuery.extend(this.data, {callback: 'JSONP_CALLBACK'});
            } else {
                newData = this.data;
            }

            newData = jQuery.extend(newData, {token: this.config.token});

            newUrl = this.url + (this.url.indexOf('?') > -1 ? '&' : '?') + jQuery.param(newData);

            return this[this.config.requestType][this.method](newUrl)
                .map(this.extractData)
                .catch(this.handleError);
        }
    }

    get method(): string {
        return this.request.method;
    }

    set method(val: string) {
        this.request.method = val;
    }

    get url(): string {
        return this.request.url;
    }

    set url(val: string) {
        this.request.url = val;
    }

    get data(): Object {
        return this.request.data;
    }

    set data(val: Object) {
        this.request.data = val;
    }
}