import { Injectable } from '@angular/core';
import { Http, Response } from '@angular/http';
import { Observable }     from 'rxjs/Observable';

declare var jQuery: any;

@Injectable()
export class Service {
    private request = {method: 'get', url: '', data: {}};

    constructor(private http: Http) {}

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

        if(this.method === 'post' || this.method === 'put') {
            return this.http[this.method](this.url, this.data)
                .map(this.extractData)
                .catch(this.handleError);
        } else {
            let newUrl = this.url + (this.url.indexOf('?') > -1 ? '&' : '?') + jQuery.param(this.data);

            return this.http[this.method](newUrl)
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