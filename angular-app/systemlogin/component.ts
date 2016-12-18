import { Component } from '@angular/core';

import { Configuration } from '../classes/configuration';
import { Service } from "../classes/service";

declare var jQuery: any;

@Component({
    moduleId: module.id,
    selector: 'system-login',
    templateUrl: 'template.html',
    styleUrls: ['styles.css']
})
export class SystemLogin {

    loginForm = {email: '', pass: '', remember: false};
    errors: string[] = [];

    constructor(public config: Configuration, private service: Service) {
        this.config.setTitle('System Login');
    }

    loginFormSubmit(event: Event): void {
        event.preventDefault();

        this.errors = [];

        this.service.method = 'post';
        this.service.url = this.config.systemLoginUrl;
        this.service.data = this.loginForm;
        console.log('submit...');
        this.service.send().subscribe(
            data => console.log(data),
            error => this.errors.push(<any>error)
        );
    }

    get lf(): any {
        return JSON.stringify(this.loginForm);
    }

}