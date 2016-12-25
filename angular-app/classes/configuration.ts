import { Injectable } from '@angular/core';

import { Settings } from '../settings';

declare var jQuery: any;

@Injectable()
export class Configuration extends Settings {
    private vars: any[];
    public auth: any;
    public profile: any;
    public loading = false;

    constructor() {
        super();
        this.setBodyClass();
        this.init();
    }

    public init(config: any = {auth: {login: false, systemLogin: false}}, profile: any = false): void {
        this.initConfig(config);
        this.initProfile(profile);
    }

    public initConfig(config: any): void {
        this.auth = config.auth;

        if(config.token) {
            this.token = config.token;
        }
    }

    set token(token: any) {
        jQuery.cookie('token', JSON.stringify(token), { expires: 1, path: '/'});
    }

    get token(): any {
        let token = jQuery.cookie('token');

        if(token) {
            token = JSON.parse(token);
        } else {
            token = {};
        }

        return token;
    }

    public initProfile(profile: any): void {
        this.profile = profile;
    }

    public getVar(name: string, def: any = false): any {
        let result = this.vars[name];

        if(!result) {
            result = def;
        }

        return result;
    }

    public setVar(name: string, val: any): void {
        this.vars[name] = val;
    }

    public setTitle(pageTitle: string): void {
        jQuery('title').text(pageTitle ? this.defaultTitle + ' > ' + pageTitle : this.defaultTitle);
    }

    public setBodyClass(newClass: string = ''): void {
        newClass = newClass ? ' ' + newClass : newClass;
        jQuery('body').prop('class', this.defaultBodyClass + newClass);
    }
}