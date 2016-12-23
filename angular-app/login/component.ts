import { Component } from '@angular/core';

import { Configuration } from '../classes/configuration';
import { Service } from "../classes/service";

declare var jQuery: any;

@Component({
    moduleId: module.id,
    selector: 'login',
    templateUrl: 'template.html',
    styleUrls: ['styles.css']
})
export class Login {

    loginForm = {email: '', pass: ''};
    errors: string[] = [];
    loading: boolean = false;

    constructor(public config: Configuration, private service: Service) {
        this.config.setTitle('Login');
    }

    loginFormSubmit(event: Event): void {
        event.preventDefault();
        this.errors = [];
        this.loading = true;

        this.service.method = 'get';//TODO: change to post
        this.service.url = this.config.loginUrl;
        this.service.data = this.loginForm;
            this.service.send().subscribe(
                data => {
                    this.config.initConfig(data.config);
                    this.loading = false;
                    if(!data.data.length) {
                        this.errors.push('Login or password incorrect');
                    } else {
                        this.config.initProfile(data.data);
                    }
                },
                error => {
                    this.errors.push(<any>error);
                    this.loading = false;
                }
            );
    }

    get lf(): any {
        return JSON.stringify(this.loginForm);
    }

}