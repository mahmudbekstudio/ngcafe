import { Injectable } from '@angular/core';

import { Settings } from '../settings';

declare var jQuery: any;

@Injectable()
export class Configuration extends Settings {
    private vars: any[];
    public isAuth = {systemLogin: false, login: false};

    constructor() {
        super();
        this.setBodyClass();
    }

    public getVar(name: string, def = false): any {
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