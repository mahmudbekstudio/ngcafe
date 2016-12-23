import { Component } from '@angular/core';

import { Configuration } from '../classes/configuration';
import { Service } from '../classes/service';

declare var jQuery: any;

@Component({
    moduleId: module.id,
    selector: 'system-login',
    templateUrl: 'template.html',
    styleUrls: ['styles.css']
})
export class SystemLogin {

    public passwordInput: string = '';
    public passwordShow: string[] = ['fa-circle-o', 'fa-circle-o', 'fa-circle-o', 'fa-circle-o'];
    public buttonsList:any[] = [1,2,3,4,5,6,7,8,9,0];
    public passwordEmpty: boolean = true;
    public passwordFull: boolean = false;

    constructor(public config: Configuration, private service: Service) {
        this.config.setTitle('System Login');

        jQuery(document).on('keyup', function(e) {
            if(e.keyCode == 8) {
                jQuery('.keybaord-btn-item.btn-danger').trigger('click');
                return false;
            } else if(e.keyCode == 13) {
                jQuery('.keybaord-btn-item.btn-primary').trigger('click');
                return false;
            } else {
                let clickedNum = parseInt(String.fromCharCode(e.keyCode));
                if(clickedNum >= 0 || clickedNum <= 9) {
                    jQuery('.keybaord-btn-item[value="' + clickedNum + '"]').trigger('click');
                }
            }
        });
    }

    btnClick(val: string): void {
        if(val === 'remove') {
            this.passwordInput = this.passwordInput.substring(0, this.passwordInput.length - 1)
            this.passwordShow[this.passwordInput.length] = 'fa-circle-o';
        } else if(val === 'enter') {
            this.service.method = 'get';//TODO: change to post
            this.service.url = this.config.systemloginUrl;
            this.service.data = {pass: this.passwordInput};
            this.service.send().subscribe(
                data => {
                    this.config.initConfig(data.config);
                },
                error => {
                    alert(<any>error);
                }
            );
        } else if(!this.passwordFull) {
            this.passwordShow[this.passwordInput.length] = 'fa-circle';
            this.passwordInput += val;
        }

        if(this.passwordInput.length === this.passwordShow.length) {
            this.passwordFull = true;
        } else {
            this.passwordFull = false;
        }

        if(this.passwordInput.length) {
            this.passwordEmpty = false;
        } else {
            this.passwordEmpty = true;
        }

        jQuery(document).focus();
    }

    exitSystem(event: Event): void {
        event.preventDefault();

        this.service.method = 'get';
        this.service.url = this.config.loginOutUrl;
        this.service.send().subscribe(
            data => {
                this.config.initConfig(data.config);
            },
            error => {
                alert(<any>error);
            }
        );
    }

}